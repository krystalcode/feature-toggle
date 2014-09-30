<?php

/**
 * This file is part of the FeatureToggle package.
 *
 * (c) Dimitris Bozelos <dbozelos@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KrystalCode\FeatureToggle;

/**
 * Implements a configuration loader that gets the variables from a PHP file.
 */
class ConfigLoaderPhp implements ConfigLoaderInterface {
    protected $input;

    /**
     * Constructor.
     *
     * @param string $input  The path to the PHP file that contains the configuration variables.
     */
    public function __construct($input)
    {
        $this->input = $input;
    }

    /**
     * Loads and returns the configuration variables from the given PHP file.
     *
     * @see ConfigLoaderInterface::load().
     *
     * @return array An array containing the loaded configuration variables.
     */
    public function load()
    {
        if (strpos($this->input, "\n") === false && is_file($this->input)) {
            if (false === is_readable($this->input)) {
                throw new Exception(sprintf('Unable to parse "%s" as the file is not readable.', $this->input));
            }
        }

        return include($this->input);
    }
}
