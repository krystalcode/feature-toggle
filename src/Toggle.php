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
 * Provides easier syntax for calling Toggles. It does so by wrapping the normal
 * calling code into a closure and returning the closure for use in the
 * application.
 *
 * @author Dimitris Bozelos <dbozelos@gmail.com>
 */
class Toggle
{
    public static function get($toggleType)
    {
        switch ($toggleType) {
            case 'yaml':
                return function ($input, $varName, $varValue = null) {
                    $loader = new ConfigLoaderYaml(new \Symfony\Component\Yaml\Parser(), $input);
                    $toggle = new ToggleConfig($loader, $varName, $varValue);
                    return $toggle->on();
                };
                break;
        }
    }
}
