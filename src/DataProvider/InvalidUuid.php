<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\DataProvider;

class InvalidUuid extends InvalidString
{
    public function values()
    {
        $faker = $this->getFaker();

        return array_merge(parent::values(), [
            $faker->word,
            $faker->md5,
            $faker->sha1,
            $faker->sha256,
        ]);
    }
}