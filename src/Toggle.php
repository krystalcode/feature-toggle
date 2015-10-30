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

use Symfony\Component\Yaml\Parser as YamlParser;

/**
 * Provides easier syntax for calling Toggles.
 *
 * @author Dimitris Bozelos <dbozelos@gmail.com>
 */
class Toggle
{
    public static function params(array $input, $varName, $varValue = null)
    {
        $loader = new ConfigLoaderArray($input);
        $toggle = new ToggleConfig($loader, $varName, $varValue);
        return $toggle->on();
    }

    public static function yaml($input, $varName, $varValue = null)
    {
        $loader = new ConfigLoaderYaml(new YamlParser(), $input);
        $toggle = new ToggleConfig($loader, $varName, $varValue);
        return $toggle->on();
    }

    public static function php($input, $varName, $varValue = null)
    {
        $loader = new ConfigLoaderPhp($input);
        $toggle = new ToggleConfig($loader, $varName, $varValue);
        return $toggle->on();
    }

    public static function ini($input, $varName, $varValue = null)
    {
        $loader = new ConfigLoaderIni($input);
        $toggle = new ToggleConfig($loader, $varName, $varValue);
        return $toggle->on();
    }

    public static function yii1($varName, $varValue = null)
    {
        $loader = new ConfigLoaderArray(\Yii::app()->params['featureToggle']);
        $toggle = new ToggleConfig($loader, $varName, $varValue);
        return $toggle->on();
    }

    public static function yii2($varName, $varValue = null)
    {
        $loader = new ConfigLoaderArray(\Yii::$app->params['featureToggle']);
        $toggle = new ToggleConfig($loader, $varName, $varValue);
        return $toggle->on();
    }

    /**
     * @Issue("Create a Symonfy bundle for better integration incl. Twig extension")
     */
    public static function symfony2($varName, $varValue = null)
    {
        $input = realpath(__DIR__ . '/../../../../app/config/feature-toggle.yml');
        $loader = new ConfigLoaderYaml(new YamlParser(), $input);
        $toggle = new ToggleConfig($loader, $varName, $varValue);
        return $toggle->on();
    }
}
