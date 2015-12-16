<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Unit\Spryker\Shared\Kernel;

use Unit\Spryker\Shared\Kernel\Fixtures\Locator;
use Unit\Spryker\Shared\Kernel\Fixtures\MissingPropertyLocator;

/**
 * @group Kernel
 * @group Locator
 * @group AbstractLocator
 */
class AbstractLocatorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @return void
     */
    public function testCreateInstanceWithoutAFactoryClassNamePatternPropertyShouldThrowException()
    {
        $this->setExpectedException('Spryker\Shared\Kernel\Locator\LocatorException');

        $locator = new MissingPropertyLocator();
    }

    /**
     * @return void
     */
    public function testCreateInstance()
    {
        $locator = new Locator('foo');

        $this->assertInstanceOf('Spryker\Shared\Kernel\AbstractLocator', $locator);
    }

}