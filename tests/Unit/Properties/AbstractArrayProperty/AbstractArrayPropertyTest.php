<?php

uses(\Sunhill\Properties\Tests\TestCase::class);
use Sunhill\Properties\Tests\TestSupport\Properties\NonAbstractArrayProperty;
use Sunhill\Properties\Properties\Exceptions\InvalidParameterException;
use Sunhill\Properties\Types\TypeInteger;
use Sunhill\Properties\Types\TypeVarchar;
use Sunhill\Properties\Facades\Properties;
use Sunhill\Properties\Properties\Exceptions\InvalidValueException;
test('set allowed type', function ($types, $pass) {
    Properties::shouldReceive('isPropertyRegistered')->andReturn($pass);
    Properties::shouldReceive('getNamespaceOfProperty')->andReturn('Namesapce');
    if (!$pass) {
        $this->expectException(InvalidParameterException::class);
    }
    $test = new NonAbstractArrayProperty();
    $test->setAllowedElementTypes($types);
    expect(true)->toBeTrue();
})->with('SetAllowedTypeProvider');
dataset('SetAllowedTypeProvider', function () {
    return [
        [TypeInteger::class, true],
        [[TypeInteger::class, TypeVarchar::class], true],
        ['integer', true],
        ['notexisting', false],
        [3.3, false],
        [[3.3,4.3], false],
        [[TypeInteger::class, 3.3], false],
    ];
});
test('simple access', function () {
    $test = new NonAbstractArrayProperty();
    expect($test->count())->toEqual(0);
});
test('write element', function ($allowed, $value, $pass) {
    if (!$pass) {
        $this->expectException(InvalidValueException::class);
    }
    $test = new NonAbstractArrayProperty();
    $test->setAllowedElementTypes($allowed);
    $test[] = $value;
    expect($test[0])->toEqual($value);
})->with('WriteElementProvider');
dataset('WriteElementProvider', function () {
    return [ 
        [null, 'ABC', true],
        [TypeVarchar::class, 'ABC', true],
        [TypeInteger::class, 123, true],
        [TypeInteger::class, 'ABC', false],
        [[TypeInteger::class, TypeVarchar::class], 'ABC', true],
    ];
});