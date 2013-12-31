<?php
/**
 * @author Ivan Lisitskiy ivan.li@livetex.ru
 * 12/31/13 1:15 PM
 */


class PotterMania
{
    public static function price(array $ids)
    {
        $price = 0;
        // получаем список книг, по которым высчитываем цену.
        // [id => count, id => count]
        $books = array_count_values($ids);

        
        // FIXME: DEBUG
        var_dump('BOOKS', $books);
        echo "DEBUG DUMP in file " . __FILE__ . " line " . __LINE__ . ";\n";


        // получим максимальное значение в массиве:
        $numberOfBaskets = max($books);
        
        $baskets = [];
        $n = 0;
        foreach ($books as $bookId => $count) {
            for ($i = 0; $i <= $count; $i++) {
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


        // FIXME: DEBUG
//        var_dump($books, $numberOfBaskets);
        var_dump($baskets);
        echo "DEBUG DUMP in file " . __FILE__ . " line " . __LINE__ . ";\n";
exit;

        return $price;
    }
} 