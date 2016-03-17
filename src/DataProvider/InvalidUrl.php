<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\DataProvider;

use stdClass;

class InvalidUrl extends AbstractDataProvider
{
    protected function values()
    {
        $faker = $this->getFaker();

        return [
            null,
            $faker->boolean(),
            $faker->word,
            $faker->words,
            $faker->randomNumber(),
            $faker->randomFloat(),
            new stdClass(),
        ];
    }
}
