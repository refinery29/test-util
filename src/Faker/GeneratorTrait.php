<?php

namespace Refinery29\Test\Util\Faker;

use Faker\Factory;
use Faker\Generator;

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
            $faker->seed(9000);
        }

        return $faker;
    }
}
