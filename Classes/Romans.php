<?php


class Romans
{
    const ONE = 'I';
    const FIVE = 'V';
    const DECADE = 'X';
    const FIFTY = 'L';
    const CENTURY = 'C';
    const FIVE_CENTURIES = 'D';
    const MILLENIUM = 'M';
    
    public static function convertDigit($number, $rank = null)
    {
        if (is_null($rank)) {
            if ($number > 3000) {
                throw new Exception("3000 is maximum digit to romans convert");
            }

            // recursive convert digits of given number to romans
            $str = '';
            $digits = str_split((string) $number);
            $count = count($digits);
            foreach ($digits as $key => $digit) {
                $str .= self::convertDigit($digit, $count - $key);
            }
            return $str;
        } else {
            switch ($rank) {
                case 4:
                    // thousands
                    return str_pad('', $number, 'M');
                    break;
                case 3:
                    // houndreds
                    return self::converter($number, self::CENTURY, self::FIVE_CENTURIES, self::MILLENIUM);
                    break;
                case 2:
                    // decades
                    return self::converter($number, self::DECADE, self::FIFTY, self::CENTURY);
                    break;
                case 1:
                    // units
                    return self::converter($number, self::ONE, self::FIVE, self::DECADE);
                    break;
                default:
                    return '';
            }
        }
    }
    
    
    private static function converter($number, $low, $middle, $high)
    {
        if ($number == 9) {
            return $low . $high;
        } elseif ($number >= 5) {
            return $middle . str_pad('', $number - 5, $low);
        } elseif ($number == 4) {
            return $low.$middle;
        } else {
            return str_pad('', $number, $low);
        }
    }
    
} 