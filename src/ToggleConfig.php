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
 * Implements a toggle that evaluates the case based on the value of a
 * configuration variable.
 *
 * @author Dimitris Bozelos <dbozelos@gmail.com>
 */
class ToggleConfig implements ToggleInterface
{
    protected $varName;
    protected $varValue;
    protected static $config;

    /**
     * Constructor.
     *
     * @param string $varName  The name of the variable to check.
     * @param mixed  $varValue The expected value of the variable. @see on().
     */
    public function __construct(ConfigLoaderInterface $configLoader, $varName, $varValue = null)
    {
        // The variables are statically stored so that we do not need to load
        // them again within the same context e.g. same request.
        // Load them only if not loaded yet.
        if (empty(self::$config)) {
            self::$config = $configLoader->load();
        }

        // Throw an exception if the configuration loaded is not in array format.
        if (!is_array(self::$config)) {
            throw new Exception(
                sprintf(
                    'The configuration loaded must be in array format, "%s" given.',
                    gettype(self::$config)
                )
            );
        }

        // Throw an exception if the requested variable is not defined.
        if (!in_array($varName, array_keys(self::$config))) {
            throw new Exception(
                sprintf(
                    'The variable "%s" is not defined.',
                    $varName
                )
            );
        }

        $this->varName  = $varName;
        $this->varValue = $varValue;
    }

    /**
     * Returns the result of the case evaluation based on the value of the
     * variable requested.
     *
     * If an expected value is given and it matches the real value, true is returned.
     * If an expected value is given and it does not match the real value, false is returned.
     * If an expected value is not given, the real value is returned. This is assumed to be boolean and an error will be thrown by the caller if not.
     *
     * @see ToggleInterface::on().
     *
     * @return boolean The result of the case evaluation.
     */
    public function on()
    {
        // If an expected value is given, return whether the real value is equal
        // to the expected value.
        if ($this->varValue !== null) {
            return self::$config[$this->varName] === $this->varValue;
        }

        // If no expected value is given, return the real value.
        return self::$config[$this->varName];
    }

    /**
     * Returns the name (key) of the requested configuration variable.
     *
     * @return string The name of the requested configuration variable.
     */
    public function getVarName()
    {
        return $this->varName;
    }

    /**
     * Returns the expected value of the requested configuration variable.
     *
     * @return string The expected value of the requested configuration variable.
     */
    public function getVarValue()
    {
        return $this->varValue;
    }

    /**
     * Returns the configuration variables loaded in the object.
     *
     * @return mixed The configuration variables.
     */
    public static function getConfig()
    {
        return self::$config;
    }

    /**
     * Clears the loaded configuration values.
     */
    public static function clear()
    {
        self::$config;
    }
}
