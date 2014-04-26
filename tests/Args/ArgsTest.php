<?php


class ArgsTest extends PHPUnit_Framework_TestCase
{
    /** @var  Args */
    protected $optionsParser;
    
    public function setUp()
    {
        $this->optionsParser = new Args();
    }
    
    
    /**
     * @dataProvider validDataProvider
     */
    public function testValidArgs($args, $expected)
    {
        $this->assertEquals($expected, $this->optionsParser->parse($args));
    }
    
    
    public function validDataProvider()
    {
        return [
            [
                ['index.php', '-h', 'my.host.com', '-p', '12refd5', '-s', 'some string'],
                ['host' => 'my.host.com', 'password' => '12refd5', 'string' => 'some string'],
            ],
            [
                ['index.php', '--host', 'my.host.com', '--password', '12refd5', '--string', 'some string'],
                ['host' => 'my.host.com', 'password' => '12refd5', 'string' => 'some string'],
            ],
            [
                ['index.php', '-d', 5],
                ['digit' => 5],
            ],
            [
                ['index.php', '-d', -75],
                ['digit' => -75],
            ],
        ];
    }


    /**
     * @dataProvider invalidDataProvider
     */
    public function testInvalidArgs($args, $exceptionName = "")
    {
        $this->setExpectedException($exceptionName);
        try {
            $this->optionsParser->parse($args);
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function invalidDataProvider()
    {
        return [
            [
                ['index.php', '-h', '-p', '12refd5', '-s', 'some string'],
                "WaitForOptionDataException"
            ],
            [
                ['index.php', '--host', 'my.host.com', '12refd5', '--string', 'some string'],
                "WaitForOptionException"
            ],
        ];
    }
} 