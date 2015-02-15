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

use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Exception\ParseException;

/**
 * Implements a configuration loader that gets the variables from a YAML file or
 * string.
 */
class ConfigLoaderYaml implements ConfigLoaderInterface {
    protected $parser;
    protected $input;

    /**
     * Constructor.
     *
     * @param Symfony\Component\Yaml\Parser $parser The YAML parser that will be used to load the variables from the .yml file.
     * @param string                        $input  The path to the YAML file or the YAML string that contains the configuration variables.
     */
    public function __construct(Parser $parser, $input)
    {
        $this->parser = $parser;
        $this->input  = $input;
    }

    /**
     * Loads and returns the configuration variables from the given YAML file or
     * string.
     *
     * Code largely taken from Symfony\Component\Yaml\Yaml::parse().
     *
     * @see ConfigLoaderInterface::load().
     *
     * @return array An array containing the loaded configuration variables.
     */
    public function load()
    {
        $file  = '';

        if (strpos($this->input, "\n") === false && is_file($this->input)) {
            if (false === is_readable($this->input)) {
                throw new ParseException(sprintf('Unable to parse "%s" as the file is not readable.', $this->input));
            }

            $file = $this->input;
            $this->input = file_get_contents($file);
        }

        try {
            return $this->parser->parse($this->input);
        } catch (ParseException $e) {
            if ($file) {
                $e->setParsedFile($file);
            }

            throw $e;
        }
    }
}
