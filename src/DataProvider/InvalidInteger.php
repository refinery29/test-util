<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\DataProvider;

use stdClass;

class InvalidInteger extends AbstractDataProvider
{
    protected function values()
    {
        $faker = $this->getFaker();

        return [
            null,
            $faker->boolean(),
            $faker->randomFloat(),
            (string) $faker->randomNumber(),
            $faker->word,
            $faker->words,
            new stdClass(),
        ];
    }
}