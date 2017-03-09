<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\DataProvider;

class InvalidScalar extends AbstractDataProvider
{
    public function values()
    {
        $faker = $this->getFaker();

        return [
            'array' => $faker->words,
            'null' => null,
            'object' => new \stdClass(),
            'resource' => \fopen(__FILE__, 'r'),
        ];
    }
}
