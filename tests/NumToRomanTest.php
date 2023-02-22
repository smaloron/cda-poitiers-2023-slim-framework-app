<?php
require "vendor/autoload.php";

use PHPUnit\Framework\TestCase;
use Seb\App\Validator\NumToRoman;

class NumToRomanTest extends TestCase
{

    public function getProvider()
    {
        return [
            [1, "I"], [2, "II"], [3, "III"], [4, "IV"],
            [5, "V"], [6, "VI"], [8, "VIII"], [9, "IX"],
            [10, "X"], [12, "XII"], [14, "XIV"], [15, "XV"],
            [2001, "MMI"]
        ];
    }


    /**
     * @dataProvider getProvider
     *
     * @param [type] $input
     * @param [type] $expected
     * @return void
     */
    public function testconvertFromProvider($input, $expected)
    {
        $numToRoman = new NumToRoman;
        $test = $numToRoman->convert($input);
        $this->assertEquals($expected, $test);
    }
}