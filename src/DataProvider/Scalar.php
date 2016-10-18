<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\DataProvider;

class Scalar extends AbstractDataProvider
{
    public function values()
    {
        $faker = $this->getFaker();

        return [
            'boolean-true' => true,
            'boolean-false' => false,
            'float' => $faker->randomFloat($faker->numberBetween(1)),
            'integer' => $faker->randomNumber(),
            'string' => $faker->word,
        ];
    }
}
