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
            'boolean-true' => true,
            'non-empty-string' => $faker->word,
            'non-empty-array' => $faker->words(),
            'float-positive' => $faker->randomFloat(3, 0.1),
            'float-negative' => -1 * $faker->randomFloat(3, 0.1),
            'integer-positive' => $faker->numberBetween(1),
            'integer-negative' => -1 * $faker->numberBetween(1),
            'object' => new \stdClass(),
        ];
    }
}
