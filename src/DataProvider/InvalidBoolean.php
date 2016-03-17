<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\DataProvider;

use Generator;
use stdClass;

class InvalidBoolean extends AbstractDataProvider
{
    /**
     * @return array|Generator
     */
    protected function values()
    {
        $faker = $this->getFaker();

        return [
            null,
            $faker->randomFloat(),
            $faker->randomNumber(),
            $faker->word,
            $faker->words,
            new stdClass(),
        ];
    }
}
