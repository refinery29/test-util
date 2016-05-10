<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Faker;

use Faker\Factory;
use InvalidArgumentException;
use Refinery29\Test\Util\Faker\Provider\Color;

trait GeneratorTrait
{
    /**
     * @param string $locale
     *
     * @return Generator
     */
    protected static function getFaker($locale = 'en_US')
    {
        static $fakers = [];

        if (!is_string($locale)) {
            throw new InvalidArgumentException('Locale should be a string');
        }

        if (!array_key_exists($locale, $fakers)) {
            $faker = Factory::create($locale);
            $faker->addProvider(new Color());
            $faker->seed(9000);

            $fakers[$locale] = $faker;
        }

        return $fakers[$locale];
    }
}
