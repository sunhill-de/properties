<?php

use Sunhill\Properties\Tests\TestCase;
use Sunhill\Properties\Properties\Exceptions\InvalidNameException;
use Sunhill\Properties\Tests\TestSupport\Properties\NonAbstractProperty;

class NameTest extends TestCase
{
     
    /**
     * @dataProvider NamesProvider
     * @param unknown $test
     * @param bool $forbidden
     */
    public function testNames($name, bool $forbidden)
    {
        if ($forbidden) {
            $this->expectException(InvalidNameException::class);
        }
        $test = new NonAbstractProperty();
        
        $test->setName($name);
        
        $this->assertTrue(true);
    }
    
    /**
     * @dataProvider NamesProvider
     */
    public function testIsValidPropertyName($name, bool $expect)
    {
        $test = new NonAbstractProperty();
        $this->assertEquals(!$expect, $test->isValidPropertyName($name));
    }
    
    public static function NamesProvider()
    {
        return [            
            ['_forbidden', true],
            ['string', true],
            ['object', true],
            ['float', true],
            ['integer', true],
            ['boolean', true],
            ['collection', true],
            ['name_with_underscores', false],
            ['namewith1digit', false],
            ['', true]
        ];    
    }
    
    
    public function testSetName()
    {
        $test = new NonAbstractProperty();
        $this->assertEquals('test_int', $test->getName());
        $test->setName('another');
        $this->assertEquals('another', $test->getName());
    }
    
    public function testForceName()
    {
        $test = new NonAbstractProperty();
        
        $test->forceName('_test');
        
        $this->assertEquals('_test', $test->getName());        
    }
    
    /**
     * @dataProvider AdditionalGetterProvider
     * @param unknown $item
     * @param unknown $value
     */
    public function testAdditionalGetter($item, $value)
    {
        $test = new NonAbstractProperty();
        $method = 'set_'.$item;
        $test->$method($value);
        $method = 'get_'.$item;
        $this->assertEquals($value, $test->$method());
    }
    
    public static function AdditionalGetterProvider()
    {
        return [
            ['test','TEST'],
            ['Test','TEST'],
            ['_Test','TEST']
        ];
    }
    
}