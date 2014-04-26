<?php
/**
 * @author Ivan Lisitskiy ivan.li@livetex.ru
 * 1/31/14 5:53 PM
 */


class WaitForOptionException extends Exception {}
class WaitForOptionDataException extends Exception {}

class Args
{
    // текущая опция которая в разборе
    protected $previousOption;
    protected $currentOption;
    
    protected $synonyms = [
        'h' => 'host',
        'p' => 'password',
        's' => 'string',
        'd' => 'digit',
        't' => 'test',
    ];
    
    protected $optionsSchema = [
        'host' => [
            'parametric' => true,
        ],
        'password' => [
            'parametric' => true,
        ],
        'string' => [
            'parametric' => true,
        ],
        'digit' => [
            'parametric' => true,
        ],
        'test' => [
            'parametric' => false,
        ]
    ];
        
    public function parse($args)
    {
        $result = [];
        // распарсим результат и вернём корректный массив параметров вызова
        // 1. первый аргумент - имя вызыванного скрипта
        $script = array_shift($args);
        
        // 2. статус текущего парсинга: ждём аргумент или данные
        $waitForData = false;
        
        foreach ($args as $arg) {
            $isOption = $this->isOption($arg);
            // если мы уже ждём данные, а получили опцию - ругаемся
            if ($waitForData === true && $isOption === true) {
                throw new WaitForOptionDataException("Needs data for " . $this->previousOption);
            }
            
            if ($isOption) {
                $waitForData = $this->isParametricOption();
                continue;
            }

            if ($waitForData === false && !$isOption) {
                throw new WaitForOptionException("Wrong data given for " . $this->previousOption);
            } elseif ($waitForData === true && !$isOption) {
                // получаем полное имя аргумента по схеме и заполняем данными
                $result[$this->currentOption] = $arg;
                $waitForData = false;
            }

            // перемещаем текущую опцию в предыдущую
            if ($isOption) {
                $this->previousOption = $this->currentOption;
            }
        }
        return $result;
    }
    
    protected function isOption($arg)
    {
        if (preg_match("#\-{1,2}([a-zA-Z\-]{1,})#", $arg, $matches)) {
            $option = $matches[1];
            $fullName = array_key_exists($option, $this->synonyms) ? $this->synonyms[$option] : $option;
            if (!array_key_exists($fullName, $this->optionsSchema)) {
                throw new Exception("Unknown option {$arg}");
            }
            $this->currentOption = $fullName;
            return true;
        }
        return false;
    }
    
    protected function isParametricOption()
    {
        return $this->optionsSchema[$this->currentOption]['parametric'];
    }
} 