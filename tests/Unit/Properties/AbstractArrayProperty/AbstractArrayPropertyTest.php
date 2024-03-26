<?php

use Sunhill\Properties\Tests\TestCase;
use Sunhill\Properties\Tests\TestSupport\Properties\NonAbstractArrayProperty;
use Sunhill\Properties\Properties\Exceptions\InvalidParameterException;
use Sunhill\Properties\Types\TypeInteger;
use Sunhill\Properties\Types\TypeVarchar;
use Sunhill\Properties\Facades\Properties;

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
        $this->assertEquals(2, $test->count());
    }
    
}