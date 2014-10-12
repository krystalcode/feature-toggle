<?php

/**
 * This file is part of the FeatureToggle package.
 *
 * (c) Dimitris Bozelos <dbozelos@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KrystalCode\FeatureToggle\Tests;

use KrystalCode\FeatureToggle\ConfigLoaderPhp;

class ConfigLoaderPhpTest extends \PHPUnit_Framework_TestCase
{
    public function testIfConstructorStoresInput()
    {
        $input  = 'filename';
        $loader = new ConfigLoaderPhp($input);
        $this->assertEquals($input, $loader->getInput());
    }

    public function testIfLoaderChecksThatInputIsFile()
    {
        $loader = new ConfigLoaderPhp(__DIR__.'/a/file/that/does/not/exist');

        try {
            $loader->load();
        } catch (\Exception $e) {
            $this->assertTrue(true);
            return;
        }

        $this->assertTrue(false);
    }
}
