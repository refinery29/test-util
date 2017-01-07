<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\DataProvider;

class InvalidIsoDate extends InvalidString
{
    public function values()
    {
        $faker = $this->getFaker();

        $date = $faker->dateTime;

        return \array_merge(parent::values(), [
            'string' => $faker->word,
            DATE_ISO8601 => $date->format(DATE_ISO8601),
            DATE_COOKIE => $date->format(DATE_COOKIE),
            DATE_RFC822 => $date->format(DATE_RFC822),
            DATE_RFC850 => $date->format(DATE_RFC850),
            DATE_RFC1036 => $date->format(DATE_RFC1036),
            DATE_RFC1123 => $date->format(DATE_RFC1123),
            DATE_RFC2822 => $date->format(DATE_RFC2822),
            DATE_RSS => $date->format(DATE_RSS),
        ]);
    }
}
