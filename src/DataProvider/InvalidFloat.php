<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\DataProvider;

class InvalidFloat extends AbstractDataProvider
{
    public function values()
    {
        $faker = $this->getFaker();

        return [
            'array' => $faker->words,
            'boolean-false' => false,
            'boolean-true' => true,
            'float-negative-casted-to-string' => (string) (-1 * $faker->randomFloat(3, 0.001)),
            'float-positive-casted-to-string' => (string) $faker->randomFloat(3, 0.001),
            'float-zero-casted-to-string' => (string) 0.0,
            'integer-negative' => -1 * $faker->numberBetween(1),
            'integer-positive' => $faker->numberBetween(1),
            'integer-zero' => 0,
            'null' => null,
            'object' => new \stdClass(),
            'resource' => \fopen(__FILE__, 'r'),
            'string' => $faker->word,
        ];
    }
}
