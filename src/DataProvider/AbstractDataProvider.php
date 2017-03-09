<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\DataProvider;

use Refinery29\Test\Util\TestHelper;

abstract class AbstractDataProvider implements DataProviderInterface
{
    use TestHelper;

    final public function data()
    {
        return $this->provideData($this->values());
    }

    /**
     * @return string[]
     */
    final protected function arrayOfStrings()
    {
        return $this->getFaker()->words;
    }

    /**
     * @return \DateTime
     */
    final protected function dateTime()
    {
        return $this->getFaker()->dateTime;
    }

    /**
     * @return float
     */
    final protected function floatNegative()
    {
        return -1 * $this->floatPositive();
    }

    /**
     * @return float
     */
    final protected function floatPositive()
    {
        return $this->getFaker()->randomFloat(3, 0.001);
    }

    /**
     * @return int
     */
    final protected function intNegative()
    {
        return -1 * $this->intPositive();
    }

    /**
     * @return int
     */
    final protected function intPositive()
    {
        return $this->getFaker()->numberBetween(1);
    }

    /**
     * @return resource
     */
    final protected function resource()
    {
        static $resource;

        if (null === $resource) {
            $resource = \fopen(__FILE__, 'r');
        }

        return $resource;
    }

    /**
     * @return string
     */
    final protected function string()
    {
        return $this->getFaker()->word;
    }
}
