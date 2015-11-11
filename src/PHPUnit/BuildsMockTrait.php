<?php

namespace Refinery29\Test\Util\PHPUnit;

/**
 * Trait BuildsMocks
 */
trait BuildsMockTrait
{
    /**
     * @param $className
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function buildMock($className)
    {
        return $this->getMockBuilder($className)
            ->disableOriginalConstructor()
            ->getMock();
    }
}
