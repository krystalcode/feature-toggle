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
 * Implements a configuration loader that gets the variables from a .ini file.
 * @see http://php.net/manual/en/function.parse-ini-file.php
 */
class ConfigLoaderIni implements ConfigLoaderInterface {
    protected $input;

    /**
     * Constructor.
     *
     * @param string $input  The path to the .ini file that contains the configuration variables.
     */
    public function __construct($input)
    {
        $this->input = $input;
    }

    /**
     * Loads and returns the configuration variables from the given .ini file.
     *
     * @see ConfigLoaderInterface::load().
     *
     * @return array An array containing the loaded configuration variables.
     */
    public function load()
    {
        // Check if the file is readable.
        if (strpos($this->input, "\n") === false && is_file($this->input)) {
            if (false === is_readable($this->input)) {
                throw new Exception(
                    sprintf(
                        'Unable to parse "%s" as the file is not readable.',
                        $this->input
                    )
                );
            }
        }

        $config = parse_ini_file($this->input);

        // Check if syntax errors were found.
        if ($config === false) {
            throw new Exception(
                sprintf(
                    'Unable to parse "%s", please check your syntax. Examples can be found at http://php.net/manual/en/function.parse-ini-file.php.',
                    $this->input
                )
            );
        }

        return $config;
    }
}
