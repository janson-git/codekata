<?php


class RomanNumeralsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider digitsDataProvider
     */
    public function testDigitsToRomans($digit, $romanExpect)
    {
        $this->assertEquals($romanExpect, Romans::convertDigit($digit));
    }
    
    public function digitsDataProvider()
    {
        return [
            [1, 'I'],
            [2, 'II'],
            [3, 'III'],
            [4, 'IV'],
            [5, 'V'],
            [6, 'VI'],
            [7, 'VII'],
            [8, 'VIII'],
            [9, 'IX'],
            [10, 'X'],
            [20, 'XX'],
            [40, 'XL'],
            [44, 'XLIV'],
            [55, 'LV'],
            [58, 'LVIII'],
            [59, 'LIX'],
            [89, 'LXXXIX'],
            [90, 'XC'],
            [94, 'XCIV'],
            [1999, 'MCMXCIX'],
            [999, 'CMXCIX'],
            [58, 'LVIII'],
        ];
    }
} 