<?php

use Sunhill\Properties\Tests\TestCase;
use Sunhill\Properties\Tests\TestSupport\Properties\NonAbstractArrayProperty;
use Sunhill\Properties\Properties\Exceptions\InvalidParameterException;
use Sunhill\Properties\Types\TypeInteger;
use Sunhill\Properties\Types\TypeVarchar;
use Sunhill\Properties\Facades\Properties;
use Sunhill\Properties\Properties\Exceptions\InvalidValueException;

class AbstractArrayPropertyTest extends TestCase
{
    
    /**
     * @dataProvider SetAllowedTypeProvider
     */
    public function testSetAllowedType($types, $pass)
    {
        Properties::shouldReceive('isPropertyRegistered')->andReturn($pass);
        Properties::shouldReceive('getNamespaceOfProperty')->andReturn('Namesapce');
        if (!$pass) {
            $this->expectException(InvalidParameterException::class);
        }
        $test = new NonAbstractArrayProperty();
        $test->setAllowedElementTypes($types);
        $this->assertTrue(true);
    }

    public static function SetAllowedTypeProvider()
    {
        return [
            [TypeInteger::class, true],
            [[TypeInteger::class, TypeVarchar::class], true],
            ['integer', true],
            ['notexisting', false],
            [3.3, false],
            [[3.3,4.3], false],
            [[TypeInteger::class, 3.3], false],
        ];    
    }
    
    public function testSimpleAccess()
    {
        $test = new NonAbstractArrayProperty();
        $this->assertEquals(0, $test->count());
    }
    
    /**
     * @dataProvider WriteElementProvider
     */
    public function testWriteElement($allowed, $value, $pass)
    {
        if (!$pass) {
            $this->expectException(InvalidValueException::class);
        }
        $test = new NonAbstractArrayProperty();
        $test->setAllowedElementTypes($allowed);
        $test[] = $value;
        $this->assertEquals($value, $test[0]);
    }
    
    public static function WriteElementProvider()
    {
        return [ 
            [null, 'ABC', true],
            [TypeVarchar::class, 'ABC', true],
            [TypeInteger::class, 123, true],
            [TypeInteger::class, 'ABC', false],
            [[TypeInteger::class, TypeVarchar::class], 'ABC', true],
        ]; 
    }
}