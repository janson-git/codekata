<?php
/**
 * @author Ivan Lisitskiy ivan.li@livetex.ru
 * 12/31/13 1:15 PM
 */


class PotterMania
{
    public static function price(array $books)
    {
        // реализуем два алгоритма для наборов: с максимально равномерными наборами
        // и с максимально длинными возможными наборами + остатки вне наборов
        $price1 = self::getTotalCost( self::costWithMinimalSets($books) );
        $price2 = self::getTotalCost( self::costWithMaximalSets($books) );

        return min([$price1, $price2]);
    }
    
    
    private static function costWithMinimalSets($books)
    {
        // получаем список книг, по которым высчитываем цену.
        // [id => count, id => count]
        $books = array_count_values($books);
        
        // получим максимальное значение в массиве:
        $numberOfBaskets = max($books) - 1;
        
        $baskets = [];
        $n = 0;
        foreach ($books as $bookId => $count) {
            for ($i = 0; $i < $count; $i++) {
                if (!isset($baskets[$n])) {
                    $baskets[$n] = [];
                }
                array_push($baskets[$n], $bookId);
                $n++;
                if ($n > $numberOfBaskets) {
                    $n = 0;
                }
            }
        }

        return $baskets;
    }
    
    
    private static function costWithMaximalSets($books)
    {
        // получим максимальное значение в массиве:
        $baskets = [];

        while(!empty($books)) {
            $unique = array_unique($books);
            array_push($baskets, $unique);
            // удаляем взятые значения из исходного массива
            foreach ($unique as $val) {
                $keys = array_search($val, $books);
                if (is_array($keys)) {
                    $key = array_pop($keys);
                } else {
                    $key = $keys;
                }
                unset($books[$key]);
            }
        }
        
        return $baskets;
    }
    
    private static function getTotalCost($baskets)
    {
        $price = 0;
        
        // считаем общую цену:
        foreach ($baskets as $basket) {
            $counter = count($basket);
            switch ($counter) {
                case 1:
                    $price += 8;
                    break;
                case 2:
                    $price += 8 * 2 * 0.95;
                    break;
                case 3:
                    $price += 8 * 3 * 0.90;
                    break;
                case 4:
                    $price += 8 * 4 * 0.8;
                    break;
                case 5:
                    $price += 8 * 5 * 0.75;
                    break;
            }
        }

        return $price;
    }
} 