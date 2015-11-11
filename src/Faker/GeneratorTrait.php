<?php

namespace Refinery29\Test\Util\Faker;

use Faker\Factory;
use Faker\Generator;
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
