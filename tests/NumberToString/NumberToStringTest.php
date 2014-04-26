<?php


class NumberToStringTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provider
     */
    public function testNumberToStringConverts($number, $expectedString)
    {
        $this->assertEquals($expectedString, NumberToStringConverter::convert($number));
    }
    
    
    public function provider()
    {
        return [
            [1, 'один'],
            [15, 'пятнадцать'],
            [25, 'двадцать пять'],
            [97, 'девяносто семь'],
            [147, 'сто сорок семь'],
            [1534, 'одна тысяча пятьсот тридцать четыре'],
            [3048, 'три тысячи сорок восемь'],
            [962, 'девятьсот шестьдесят два'],
            [9669, 'девять тысяч шестьсот шестьдесят девять'],
            [12488, 'двенадцать тысяч четыреста восемьдесят восемь'],
            [38011, 'тридцать восемь тысяч одиннадцать'],
            [51791, 'пятьдесят одна тысяча семьсот девяносто один'],
        ];
    }
} 