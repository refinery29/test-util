<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\DataProvider;

class InvalidIntegerish extends AbstractDataProvider
{
    public function values()
    {
        $faker = $this->getFaker();

        return [
            'array' => $faker->words,
            'boolean-false' => false,
            'boolean-true' => true,
            'float-negative' => -1 * $faker->randomFloat(3, 0.001),
            'float-negative-casted-to-string' => (string) (-1 * $faker->randomFloat(3, 0.001)),
            'float-positive' => $faker->randomFloat(3, 0.001),
            'float-positive-casted-to-string' => (string) $faker->randomFloat(3, 0.001),
            'null' => null,
            'object' => new \stdClass(),
            'resource' => \fopen(__FILE__, 'r'),
            'string' => $faker->word,
        ];
    }
}
