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

use KrystalCode\FeatureToggle\ConfigLoaderArray;

class ConfigLoaderArrayTest extends \PHPUnit_Framework_TestCase
{
    public function testIfConstructorStoresInput()
    {
        $input  = array(
            'feature' => true,
        );
        $loader = new ConfigLoaderArray($input);
        $this->assertEquals($input, $loader->getInput());
    }
}
