<?php
/**
 * @author Ivan Lisitskiy ivan.li@livetex.ru
 * 4/4/14 4:14 PM
 */


class MinSpreadSearcher
{
    /**
     * @param string $data
     * @return null|string
     */
    public function findIndexOfMinSpread($data)
    {
        // 1. разбить на строки
        $data = str_replace("\r", "", $data);
        
        // 2. разбить строки на колонки
        $lines = explode("\n", $data);
        
        // 3. получить ИНДЕКС, МАКСИМУМ, МИНИМУМ (колонки 1, 2, 3), и вернуть ИНДЕКС с минимальной разницей
        $minIndex = null;
        $minSpread = null;
        
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) {
                continue;
            }
            $result = preg_split("#\s+#", $line);

            $index = $result[0];
            $max = $result[1];
            $min = $result[2];
            
            if (!is_numeric($max) || !is_numeric($min)) {
                continue;
            }
            
            $spread = $max - $min;
            if (!is_null($minSpread)) {
                if ($minSpread > $spread) {
                    $minSpread = $spread;
                    $minIndex = $index;
                }
            } else {
                $minSpread = $spread;
                $minIndex = $index;
            }
        }
        
        return $minIndex;
    }
} 