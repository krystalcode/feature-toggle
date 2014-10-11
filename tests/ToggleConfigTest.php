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

use KrystalCode\FeatureToggle\ToggleConfig;

class ToggleConfigTest extends \PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        // The config is statically stored.
        // Clear it after each test so that if config is loaded in one test it
        // does not affect subsequent tests.
        ToggleConfig::clear();
    }

    public function testIfConstructorLoadsVariables()
    {
        $config = array(
            'varName1' => 'varValue1',
            'varName2' => 'varValue2',
            'varName3' => 'varValue3',
        );

        $loader = $this->getMockBuilder('\KrystalCode\FeatureToggle\ConfigLoaderPhp')
            ->disableOriginalConstructor()
            ->getMock();

        $loader->expects($this->once())
            ->method('load')
            ->willReturn($config);

        $toggle = new ToggleConfig($loader, 'varName1');

        $this->assertEquals($config, $toggle::get());
    }

    /**
     * @dataProvider providerTestIfConstructorChecksThatConfigIsArray
     */
    public function testIfConstructorChecksThatConfigIsArray($config)
    {
        $loader = $this->getMockBuilder('\KrystalCode\FeatureToggle\ConfigLoaderPhp')
            ->disableOriginalConstructor()
            ->getMock();

        $loader->expects($this->once())
            ->method('load')
            ->willReturn($config);

        try {
            $toggle = new ToggleConfig($loader, 'varName1');
        } catch (\Exception $e) {
            $this->assertTrue(true);
            return;
        }

        $this->assertTrue(false);
    }

    public function testIfConstructorChecksThatRequestedVariableIsDefined()
    {
        $config = array(
            'varName1' => 'varValue1',
        );

        $loader = $this->getMockBuilder('\KrystalCode\FeatureToggle\ConfigLoaderPhp')
            ->disableOriginalConstructor()
            ->getMock();

        $loader->expects($this->once())
            ->method('load')
            ->willReturn($config);

        try {
            $toggle = new ToggleConfig($loader, 'varThatIsNotDefined');
        } catch (\Exception $e) {
            $this->assertTrue(true);
            return;
        }

        $this->assertTrue(false);
    }

    public function testResultForVariableWithBooleanTrueValue()
    {
        $config = array(
            'varName1' => true,
        );

        $loader = $this->getMockBuilder('\KrystalCode\FeatureToggle\ConfigLoaderPhp')
            ->disableOriginalConstructor()
            ->getMock();

        $loader->expects($this->once())
            ->method('load')
            ->willReturn($config);

        $toggle = new ToggleConfig($loader, 'varName1');

        $this->assertTrue($toggle->on());
    }

    public function testResultForVariableWithBooleanFalseValue()
    {
        $config = array(
            'varName1' => false,
        );

        $loader = $this->getMockBuilder('\KrystalCode\FeatureToggle\ConfigLoaderPhp')
            ->disableOriginalConstructor()
            ->getMock();

        $loader->expects($this->once())
            ->method('load')
            ->willReturn($config);

        $toggle = new ToggleConfig($loader, 'varName1');

        $this->assertFalse($toggle->on());
    }

    public function testResultForVariableWithStringValue()
    {
        $config = array(
            'varName1' => 'varValue1',
        );

        $loader = $this->getMockBuilder('\KrystalCode\FeatureToggle\ConfigLoaderPhp')
            ->disableOriginalConstructor()
            ->getMock();

        $loader->expects($this->once())
            ->method('load')
            ->willReturn($config);

        $toggle = new ToggleConfig($loader, 'varName1', 'varValue1');

        $this->assertTrue($toggle->on());
    }

    public function providerTestIfConstructorChecksThatConfigIsArray() {
        return array(
            array(''),
            array(1),
            array(null),
            array(true),
            array(new \StdClass)
        );
    }
}
