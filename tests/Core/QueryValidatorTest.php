<?php
/**
 * @author Ivan Lisitskiy ivan.li@livetex.ru
 * 12/30/13 1:41 PM
 */


class QueryValidatorTest extends PHPUnit_Framework_TestCase
{
    /** @var  ReflectionClass */
    protected $qValidator;

    const CORRECT_QUERY_DATETIME_AND_OPERATOR = 'correctQueryDateTimeAndOperator';
    const CORRECT_QUERY_DATE_AND_OPERATOR = 'correctQueryDateAndOperator';

    protected $reflectionMethods = [
        self::CORRECT_QUERY_DATETIME_AND_OPERATOR => null,
        self::CORRECT_QUERY_DATE_AND_OPERATOR => null,
    ];
    
    public function setUp()
    {
        $reflectionClass = new ReflectionClass('\App\Model\Core\QueryValidator');
        
        foreach ($this->reflectionMethods as $methodName => &$value) {
            $method = $reflectionClass->getMethod($methodName);
            $method->setAccessible('public');
            $value = $method;
        }
        unset($value);
        
        $this->qValidator = $reflectionClass;
    }

    /**
     * @dataProvider dateTimeCorrectionProvider
     */
    public function testCorrectQueryDateTimeAndOperator($operator, $date, $expectedOperator, $expectedDate)
    {
        $result = $this->reflectionMethods[self::CORRECT_QUERY_DATETIME_AND_OPERATOR]->
            invoke(new \App\Model\Core\QueryValidator(), $operator, $date);

        $this->assertEquals($expectedOperator, $result[0]);
        $this->assertEquals($expectedDate, $result[1]);
    }
    
    public function dateTimeCorrectionProvider()
    {
        return [
            ['>', '2013-12-01 12:00:00', '>=', '2013-12-01 12:00:01'],
            ['<', '2013-12-01 12:00:00', '<=', '2013-12-01 11:59:59'],
            ['>=', '2013-12-01 12:00:00', '>=', '2013-12-01 12:00:00'],
            ['<=', '2013-12-01 12:00:00', '<=', '2013-12-01 12:00:00'],

            ['>', '2013-12-01 23:59:59', '>=', '2013-12-02 00:00:00'],
            ['<', '2013-12-01 00:00:00', '<=', '2013-11-30 23:59:59'],
            // если вдруг в валидатор не передали время
            ['>', '2013-12-01', '>=', '2013-12-01 00:00:01'],
            ['<', '2013-12-01', '<=', '2013-11-30 23:59:59'],
        ];
    }


    /**
     * @dataProvider dateCorrectionProvider
     */
    public function testCorrectQueryDateAndOperator($operator, $date, $expectedOperator, $expectedDate)
    {
        $result = $this->reflectionMethods[self::CORRECT_QUERY_DATE_AND_OPERATOR]->
            invoke(new \App\Model\Core\QueryValidator(), $operator, $date);

        $this->assertEquals($expectedOperator, $result[0]);
        $this->assertEquals($expectedDate, $result[1]);
    }

    public function dateCorrectionProvider()
    {
        return [
            ['>', '2013-12-01', '>=', '2013-12-02'],
            ['<', '2013-12-01', '<=', '2013-11-30'],
            ['>=', '2013-12-01', '>=', '2013-12-01'],
            ['<=', '2013-12-01', '<=', '2013-12-01'],

            // если вдруг передали время в валидатор, не учитывающий время
            ['>', '2013-12-01 12:00:00', '>=', '2013-12-02'],
            ['<', '2013-12-01 12:00:00', '<=', '2013-11-30'],
        ];
    }
} 