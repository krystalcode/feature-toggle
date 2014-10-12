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
     * @param string $input The path to the PHP file that contains the configuration variables.
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
        // Check if the input is a file.
        if (!is_file($this->input)) {
            throw new Exception(
                sprintf(
                    'The input "%s" is not a file.',
                    $this->input
                )
            );
        }

        // Check if the input is readable.
        if (!is_readable($this->input)) {
            throw new Exception(
                sprintf(
                    'The input file "%s" is not readable.',
                    $this->input
                )
            );
        }

        return include($this->input);
    }

    /**
     * Returns the input passed to the object.
     *
     * @return string The input that should be the path to the php configuration file.
     */
    public function getInput()
    {
        return $this->input;
    }
}
