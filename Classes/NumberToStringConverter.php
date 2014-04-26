<?php


class NumberToStringConverter
{
    protected static $numbers = [
        1 => 'один',
        2 => 'два',
        3 => 'три',
        4 => 'четыре',
        5 => 'пять',
        6 => 'шесть',
        7 => 'семь',
        8 => 'восемь',
        9 => 'девять',
        10 => 'десять',
        11 => 'одиннадцать',
        12 => 'двенадцать',
        13 => 'тринадцать',
        14 => 'четырнадцать',
        15 => 'пятнадцать',
        16 => 'шестнадцать',
        17 => 'семнадцать',
        18 => 'восемнадцать',
        19 => 'девятнадцать',
        20 => 'двадцать',
        30 => 'тридцать',
        40 => 'сорок',
        50 => 'пятьдесят',
        60 => 'шестьдесят',
        70 => 'семьдесят',
        80 => 'восемьдесят',
        90 => 'девяносто',
    ];

    protected static $houndreds = [
        1 => 'сто',
        2 => 'двести',
        3 => 'триста',
        4 => 'четыреста',
        5 => 'пятьсот',
        6 => 'шестьсот',
        7 => 'семьсот',
        8 => 'восемьсот',
        9 => 'девятьсот',
    ];
    
    
    public static function convert($number)
    {
        $parts = [];
        
        // смотрим количество цифр. Сначала фильтруем двузначные. Если таковых не найдётся,
        // то два последних разряда фильтруем по отдельности.
        $digits = str_split($number);
        $count = count($digits);
        if ($count == 1) {
            return self::$numbers[$number];
        }
        if ($count == 2) {
            return self::decadePart($number);
        }
        
        // получим отдельно десятки и единицы:
        $decadeNumber = (integer) substr($number, -2);
        if ($decadeNumber > 0) {
            $decadesPart = self::decadePart($decadeNumber);
            array_unshift($parts, $decadesPart);
        }
        
        // сотни и тысячи добавляем к результату позже.
        $houndreds = (integer) substr($number, -3, 1);
        if ($houndreds !== 0) {
            $houndredsPart = self::$houndreds[$houndreds];
            array_unshift($parts, $houndredsPart);
        }
        
        $thousands = substr($number, 0, $count - 3);
        if ($thousands > 0) {
            $thousandsParts = self::decadePart($thousands);
            $lastNum = substr($thousands, -1);
            if (in_array($lastNum, [1,2])) {
                $thousandsParts = str_replace(['один', 'два'], ['одна', 'две'], $thousandsParts);
            }
            // и добавим 'тысяча' в нужном склонении
            $string = ' тысяч';
            if ($lastNum == 1) {
                $string = ' тысяча';
            } elseif (in_array($lastNum, [2,3,4]) && !in_array($thousands, [12,13,14])) {
                $string = ' тысячи';
            }
            $thousandsParts .= $string;
            
            array_unshift($parts, $thousandsParts);
        }
        
        return implode(' ', $parts);
    }
    
    protected static function decadePart($number)
    {
        $digits = str_split($number);
        if (array_key_exists($number, self::$numbers)) {
            return self::$numbers[$number];
        }
        $decades = $digits[0] * 10;
        $units = $digits[1];

        return self::$numbers[$decades] . ' ' . self::$numbers[$units];
    }
} 