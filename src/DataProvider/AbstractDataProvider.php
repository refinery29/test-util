<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\DataProvider;

use Refinery29\Test\Util\Faker\GeneratorTrait;

abstract class AbstractDataProvider implements DataProviderInterface
{
    use GeneratorTrait;
    use DataProviderTrait;

    /**
     * @return array
     */
    abstract protected function values();

    public function data()
    {
        return $this->provideData($this->values());
    }
}
