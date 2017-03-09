<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\DataProvider;

class InvalidNumeric extends AbstractDataProvider
{
    public function values()
    {
        $faker = $this->getFaker();

        return [
            'array' => $faker->words,
            'boolean-false' => false,
            'boolean-true' => true,
            'null' => null,
            'object' => new \stdClass(),
            'resource' => \fopen(__FILE__, 'r'),
            'string' => $faker->word,
        ];
    }
}
