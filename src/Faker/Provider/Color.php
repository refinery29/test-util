<?php

namespace Refinery29\Test\Util\Faker\Provider;

class Color
{
    /**
     * @link https://github.com/fzaninotto/Faker/blob/v1.5.0/src/Faker/Provider/Color.php#L45-L51
     *
     * @example '#fa3cc2ff'
     */
    public static function hexColorWithAlpha()
    {
        return '#' . str_pad(dechex(mt_rand(1, 4294967295)), 6, '0', STR_PAD_LEFT);
    }

    /**
     * @example '#fa0'
     */
    public static function hexColorShort()
    {
        return '#' . str_pad(dechex(mt_rand(1, 4095)), 3, '0', STR_PAD_LEFT);
    }
}
