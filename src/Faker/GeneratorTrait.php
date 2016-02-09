<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Faker;

use Faker\Factory;
use Refinery29\Test\Util\Faker\Provider\Color;

trait GeneratorTrait
{
    /**
     * @return Generator
     */
    protected function getFaker()
    {
        static $faker;

        if ($faker === null) {
            $faker = Factory::create('en_US');
            $faker->addProvider(new Color());
            $faker->seed(9000);
        }

        return $faker;
    }
}
