<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\DataProvider;

use Generator;
use Refinery29\Test\Util\Faker\GeneratorTrait;
use stdClass;

class InvalidString implements DataProviderInterface
{
    use GeneratorTrait;

    /**
     * @return array|Generator
     */
    public function data()
    {
        $faker = $this->getFaker();

        $values = [
            null,
            $faker->boolean(),
            $faker->words,
            $faker->randomNumber(),
            $faker->randomFloat(),
            new stdClass(),
        ];

        foreach ($values as $value) {
            yield [
                $value,
            ];
        }
    }
}
