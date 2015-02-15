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
 * Implements a configuration loader that gets the variables from a PHP array.
 */
class ConfigLoaderArray implements ConfigLoaderInterface
{
    protected $input;

    /**
     * Constructor.
     *
     * @param array $input A PHP array that contains the configuration variables.
     */
    public function __construct($input)
    {
        $this->input = $input;
    }

    /**
     * Returns the configuration variables from the already loaded PHP array.
     *
     * @see ConfigLoaderInterface::load().
     *
     * @return array An array containing the loaded configuration variables.
     */
    public function load()
    {
        return $this->input;
    }

    /**
     * Returns the input passed to the object.
     *
     * @return array The input that should be the array containing the configuration variables.
     */
    public function getInput()
    {
        return $this->input;
    }
}
