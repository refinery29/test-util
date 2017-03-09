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
            'float' => $faker->randomFloat(3, 0.001),
            'null' => null,
            'object' => new \stdClass(),
            'string' => $faker->word,
        ];
    }
}
