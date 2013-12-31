<?php


class ValidatorTest extends PHPUnit_Framework_TestCase
{
    /** @var  \App\Model\Core\Validator */
    protected $validator;
    
    public function setUp()
    {
        $this->validator = new \App\Model\Core\Validator();
    }


    
    /**
     * @dataProvider requiredDataProvider
     */
    public function testRequireValidator($value, $expected, $message = '')
    {
        $this->assertEquals($expected, $this->validator->required($value), $message);
    }

    /**
     * @dataProvider lengthDataProvider
     */
    public function testLengthValidator($value, $params, $expected, $message = '')
    {
        $this->assertEquals($expected, $this->validator->length($value, $params), $message);
    }

    /**
     * @dataProvider emailProvider
     */
    public function testEmailValidator($value, $expected, $message = '')
    {
        $this->assertEquals($expected, $this->validator->email($value), $message);
    }

    /**
     * @dataProvider urlProvider
     */
    public function testUrlValidator($value, $expected, $message = '')
    {
        $this->assertEquals($expected, $this->validator->url($value), $message);
    }

    /**
     * @dataProvider digitProvider
     */
    public function testDigitValidator($value, $expected, $message = '')
    {
        $this->assertEquals($expected, $this->validator->digit($value), $message);
    }

    /**
     * @dataProvider matchProvider
     */
    public function testMatchValidator($value, $params, $expected, $message = '')
    {
        $this->assertEquals($expected, $this->validator->match($value, $params), $message);
    }

    /**
     * @dataProvider booleanProvider
     */
    public function testBooleanValidator($value, $params, $expected, $message = '')
    {
        $this->assertEquals($expected, $this->validator->boolean($value, $params), $message);
    }

    /**
     * @dataProvider stringProvider
     */
    public function testStringValidator($value, $expected, $message = '')
    {
        $this->assertEquals($expected, $this->validator->string($value), $message);
    }

    /**
     * @dataProvider stringProvider
     */
    public function testTextValidator($value, $expected, $message = '')
    {
        $this->assertEquals($expected, $this->validator->text($value), $message);
    }

    /**
     * @dataProvider integerProvider
     */
    public function testIntegerValidator($value, $expected, $message = '')
    {
        $this->assertEquals($expected, $this->validator->integer($value), $message);
    }

    /**
     * @dataProvider dateProvider
     */
    public function testDateValidator($value, $expected, $message = '')
    {
        $this->assertEquals($expected, $this->validator->date($value), $message);
    }
    

    public function requiredDataProvider()
    {
        // $value, $expected result of validator, $message on validation error
        return [
            [null, false, 'required must return false on null value'],
            ['', false, 'required must return false on \'\' value'],
            [123.5, true, 'required must return true on any not empty value'],
            [54, true, 'required must return true on any not empty value'],
            ['string', true, 'required must return true on any not empty value'],
            [true, true, 'required must return true on any not empty value'],
            [false, true, 'required must return true on any not empty value'],
        ];
    }


    public function lengthDataProvider()
    {
        // $value, $params, $expected validation result, $message of validation error
        return [
            [null, ['min' => 2], false],
            ['', ['min' => 2], false],

            [23, ['min' => 3], false],
            [2363, ['max' => 3], false],

            ['string', ['min' => 7], false],
            ['string', ['max' => 5], false],
            ['string', ['min' => 2, 'max' => 5], false],

            ['string of some long correct value', null, true],
            ['string of some long correct value', ['min' => 5], true],
            ['string of some long correct value', ['max' => 50], true],
        ];
    }


    public function emailProvider()
    {
        // $value, $expected, $message
        return [
            // false
            [null, false],
            ['', false],
            ['someIncorrectString', false],
            ['someInc@rrectString', false],
            [234, false],
            // true
            ['some@correct.email', true],
            ['test@email.domain.test', true],
            ['combo.name@email.domain.test', true],
            ['combo-name_here@email.domain.test', true],
        ];
    }


    public function urlProvider()
    {
        // $value, $expected, $message
        return [
            // false
            [null, false],
            ['', false],
            ['someIncorrectString', false],
            ['incorrect.url', false],
            [234, false],
            // true
            ['scheme://domain', true],
            ['scheme://domain.url', true],
            ['scheme://domain.url/subdirectory', true],
        ];
    }


    public function digitProvider()
    {
        // $value, $expected, $message
        return [
            // false
            [null, false],
            ['', false],
            ['string', false],
            [true, false],
            [false, false],
            ['45,5', false],
            // false
            ['35.5', true],
            ['695', true],
            [832, true],
            [23.67, true],
        ];
    }


    public function matchProvider()
    {
        // $value, $params, $expected, $message
        return [
            ['some string 54', ['pattern' => '|^\d+$|'], false],
            ['some string 54', ['pattern' => '|^\w+$|'], false],
            ['some string - 54', ['pattern' => '|^[\d\w]+$|'], false],
            ['', ['pattern' => '|^[\d\w]+$|'], false],
            ['$#&*!@*()', ['pattern' => '|^[\w]+$|'], false],
            
            ['2013-12-23', ['pattern' => '|\d{2,4}-\d{2}-\d{2}|'], true],
            ['some string without digits', ['pattern' => '|[^\d]*|'], true],
        ];
    }


    public function booleanProvider()
    {
        // $value, $params, $expected, $message
        return [
            // false
            [null, null, false],
            ['', null, false],
            ['string', null, false],
            ['534', null, false],
            [534, null, false],
            // strict false
            ['true', ['strict' => true], false],
            ['false', ['strict' => true], false],
            [1, ['strict' => true], false],
            [0, ['strict' => true], false],
            ['1', ['strict' => true], false],
            ['0', ['strict' => true], false],
            
            // true
            ['true', null, true],
            ['false', null, true],
            ['1', null, true],
            ['0', null, true],
            [1, null, true],
            [0, null, true],
            [true, null, true],
            [false, null, true],
            // strict true
            [true, ['strict' => true], true],
            [false, ['strict' => true], true],
        ];
    }


    public function stringProvider()
    {
        // $value, $expected, $message
        return [
            // false
            [457, false],
            [34.5, false],
            [true, false],
            [false, false],
            [null, false],
            // true
            ['some string here', true],
            ['452', true],
            ['55.4', true],
            ['null', true],
            ['true', true],
            ['false', true],
            
            // check utf-8
            [mb_convert_encoding('строка для проверки кодировок', 'Windows-1251', 'UTF-8'), false],
            ['строка для проверки кодировок', true],
        ];
    }


    public function integerProvider()
    {
        // $value, $expected, $message
        return [
            // false
            ['43.3', false, 'is float in string!'],
            ['some string', false, 'is string!'],
            [45.4, false, 'is float!'],
            [null, false, 'is null!'],
            [false, false, 'is boolean!'],
            [true, false, 'is boolean!'],
            // true
            ['123', true],
            [1, true],
            [5546, true],
            [-567, true],
        ];
    }


    public function dateProvider()
    {
        // $value, $expected, $message
        return [
            // false
            ['2013-13-05', false],
            ['2013-12-32', false],
            ['2013/12/32', false],
            ['00-13-32', false],
            ['string', false],
            [null, false],
            // true
            ['2013-12-29', true],
            ['2013-01-01', true],
            ['2013/08/15', true],
        ];
    }
    
    
    
    public function testValidationCastOnData()
    {
        $data = [
            'castToInt'     => '45',
            'castToInt2'    => '67',
            'castToFloat'   => '4.673',
            'castToBoolean' => 1,
            'emptyValue'    => '',
            'stringField'   => 'some string value',
        ];
        
        $rules = [
            ['castToInt', 'digit'],
            ['castToInt2', 'integer'],
            ['castToFloat', 'digit'],
            ['castToBoolean', 'boolean'],
            ['emptyValue', 'required', ['default' => 456]],
            ['stringField', 'string'],
        ];
        
        // check casts in validation process
        $valid = $this->validator->valid($data, $rules);
        $this->assertTrue($valid);
        
        $validatedData = $this->validator->getDataArray();
        $this->assertTrue( is_integer($validatedData['castToInt']) );
        $this->assertTrue( is_integer($validatedData['castToInt2']) );
        $this->assertTrue( is_float($validatedData['castToFloat']) );
        $this->assertTrue( is_bool($validatedData['castToBoolean']) );
        $this->assertTrue( $validatedData['emptyValue'] === 456 );
        $this->assertTrue( $validatedData['stringField'] === 'some string value' );
        
        // check data with no cast!
        $valid = $this->validator->valid($data, $rules, false);
        $this->assertTrue($valid);
        
        $validatedData = $this->validator->getDataArray();
        $this->assertFalse( is_integer($validatedData['castToInt']) );
        $this->assertFalse( is_integer($validatedData['castToInt2']) );
        $this->assertFalse( is_float($validatedData['castToFloat']) );
        $this->assertFalse( is_bool($validatedData['castToBoolean']) );
        // при кастовании строка остаётся той же строкой.
        $this->assertTrue( $validatedData['stringField'] === 'some string value' );
    }
    
    public function testRuleWithTrimFilter()
    {
        $data = [
            // строка с ведущими и концевыми пробелами. После trim будет иметь длину 26 символов
            'untrimmed_string' => '  some untrimmed string here   ',
        ];
        
        $rules = [
            // если строка не триммится - она не впишется в эти ограничения
            ['untrimmed_string', 'length', ['min' => 26, 'max' => 30], 'trim'],
        ];
        
        $isValid = $this->validator->valid($data, $rules);
        $validatedData = $this->validator->getDataArray();

        $this->assertTrue($isValid);
        // в процессе валидации данные прошли через фильтр.
        $this->assertTrue(strlen($validatedData['untrimmed_string']) == 26);
        
        // а ещё, данные можно получить прямо из валидатора по ключу:
        $this->assertTrue(strlen($this->validator['untrimmed_string']) == 26);
    }
    
    public function testStringAndTextValidators()
    {
        $data = [
            'stringField' => 'some string value',
            'textField'   => 'some string value',
        ];

        $rulesCorrect = [
            ['stringField', 'string'],
            ['textField', 'text'],
        ];
        $rulesIncorrect = [
            ['stringField', 'string', ['length' => 10]],
            ['textField', 'text', ['length' => 10]],
        ];
        
        $this->assertFalse($this->validator->valid($data, $rulesIncorrect));
        $this->assertTrue($this->validator->valid($data, $rulesCorrect));
    }
    
    public function testDefaultsInRequiredValidator()
    {
        $data = [
            'emptyField' => '',
            'nullField'  => null,
        ];
        $rules = [
            ['emptyField', 'required', ['default' => 4567]],
            ['nullField', 'required', ['default' => 'qwerty']],
        ];
        
        $this->assertTrue($this->validator->valid($data, $rules));
        
        $this->assertTrue($this->validator['emptyField'] === 4567);
        $this->assertTrue($this->validator['nullField'] === 'qwerty');
    }
    
    public function testRequiredValidator()
    {
        $data = [
            'emptyField' => '',
            'nullField'  => null,
        ];
        $rules = [
            ['emptyField', 'required'],
            ['nullField', 'required'],
        ];
        $this->assertFalse($this->validator->valid($data, $rules));

        $data = [
            'goodField' => 'some not empty value',
        ];
        $rules = [
            ['goodField', 'required'],
        ];
        $this->assertTrue($this->validator->valid($data, $rules));
    }
}
