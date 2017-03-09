<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\DataProvider;

/**
 * @link http://php.net/manual/en/language.types.boolean.php#language.types.boolean.casting
 */
class Truthy extends AbstractDataProvider
{
    public function values()
    {
        $faker = $this->getFaker();

        return [
            'array-not-empty' => $faker->words(),
            'boolean-true' => true,
            'float-negative' => -1 * $faker->randomFloat(3, 0.001),
            'float-positive' => $faker->randomFloat(3, 0.001),
            'integer-negative' => -1 * $faker->numberBetween(1),
            'integer-positive' => $faker->numberBetween(1),
            'object' => new \stdClass(),
            'string-not-empty' => $faker->word,
        ];
    }
}
