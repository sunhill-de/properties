<?php

uses(\Sunhill\Properties\Tests\TestCase::class);
use Sunhill\Properties\Managers\PropertiesManager;

use Sunhill\Properties\Managers\Exceptions\PropertyClassDoesntExistException;
use Sunhill\Properties\Managers\Exceptions\GivenClassNotAPropertyException;
use Sunhill\Properties\Managers\Exceptions\PropertyNotRegisteredException;
use Sunhill\Properties\Managers\Exceptions\PropertyNameAlreadyRegisteredException;
use Sunhill\Properties\Managers\Exceptions\UnitNameAlreadyRegisteredException;
use Sunhill\Properties\Managers\Exceptions\UnitNotRegisteredException;
use Sunhill\Properties\Tests\TestSupport\Properties\NonAbstractProperty;


test('register property', function () {
    $test = new PropertiesManager();
    $test->registerProperty(NonAbstractProperty::class);

    expect(isset(getProtectedProperty($test, 'registered_properties')['NonAbstractProperty']))->toBeTrue();
});

test('register double property', function () {
    $this->expectException(PropertyNameAlreadyRegisteredException::class);

    $test = new PropertiesManager();
    $test->registerProperty(NonAbstractProperty::class);
    $test->registerProperty(NonAbstractProperty::class);
});

test('register double property with alias', function () {
    $test = new PropertiesManager();
    $test->registerProperty(NonAbstractProperty::class);
    $test->registerProperty(NonAbstractProperty::class,'alias');

    expect(isset(getProtectedProperty($test, 'registered_properties')['NonAbstractProperty']))->toBeTrue();
    expect(isset(getProtectedProperty($test, 'registered_properties')['alias']))->toBeTrue();
});

test('register property with non accessible class', function () {
    $this->expectException(PropertyClassDoesntExistException::class);
    $test = new PropertiesManager();

    $test->registerProperty('something');
});

test('register property with no property class', function () {
    $this->expectException(GivenClassNotAPropertyException::class);
    $test = new PropertiesManager();

    $test->registerProperty(\StdClass::class);
});

test('property registred', function () {
    $test = new PropertiesManager();
    $test->registerProperty(NonAbstractProperty::class);

    expect($test->isPropertyRegistered('NonAbstractProperty'))->toBeTrue();
    expect($test->isPropertyRegistered(NonAbstractProperty::class))->toBeTrue();
    expect($test->isPropertyRegistered(new NonAbstractProperty()))->toBeTrue();
    expect($test->isPropertyRegistered('nonexisting'))->toBeFalse();
});

test('get namespace of property pass', function () {
    $test = new PropertiesManager();
    $test->registerProperty(NonAbstractProperty::class);

    expect($test->getNamespaceOfProperty('NonAbstractProperty'))->toEqual(NonAbstractProperty::class);
    expect($test->getNamespaceOfProperty(NonAbstractProperty::class))->toEqual(NonAbstractProperty::class);
    expect($test->getNamespaceOfProperty(new NonAbstractProperty()))->toEqual(NonAbstractProperty::class);
});

test('get namespace of property fail', function () {
    $this->expectException(PropertyNotRegisteredException::class);

    $test = new PropertiesManager();
    $test->registerProperty(NonAbstractProperty::class);

    $test->getNamespaceOfProperty('nonexisting');
});

test('get name of property pass', function () {
    $test = new PropertiesManager();
    $test->registerProperty(NonAbstractProperty::class);

    expect($test->getNameOfProperty('NonAbstractProperty'))->toEqual('NonAbstractProperty');
    expect($test->getNameOfProperty(NonAbstractProperty::class))->toEqual('NonAbstractProperty');
    expect($test->getNameOfProperty(new NonAbstractProperty()))->toEqual('NonAbstractProperty');
});

test('get name of property fail', function () {
    $this->expectException(PropertyNotRegisteredException::class);

    $test = new PropertiesManager();
    $test->registerProperty(NonAbstractProperty::class);

    $test->getNameOfProperty('nonexisting');
});

test('register unit', function () {
    $test = new PropertiesManager();
    $test->registerUnit('test_name','test_unit', 'test_group', 'test_basic');

    expect(isset(getProtectedProperty($test, 'registered_units')['test_name']))->toBeTrue();
});

test('register double unit', function () {
    $this->expectException(UnitNameAlreadyRegisteredException::class);

    $test = new PropertiesManager();
    $test->registerUnit('test_name','test_unit', 'test_group', 'test_basic');
    $test->registerUnit('test_name','test_unit', 'test_group', 'test_basic');
});

test('unit registred', function () {
    $test = new PropertiesManager();
    $test->registerUnit('test_name','test_unit', 'test_group', 'test_basic');

    expect($test->isUnitRegistered('test_name'))->toBeTrue();
    expect($test->isUnitRegistered('unknown'))->toBeFalse();
});

test('get unit', function () {
    $test = new PropertiesManager();
    $test->registerUnit('test_name','test_unit', 'test_group', 'test_basic');

    expect($test->getUnit('test_name'))->toEqual('test_unit');
});

test('get unit fail', function () {
    $this->expectException(UnitNotRegisteredException::class);

    $test = new PropertiesManager();
    $test->registerUnit('test_name','test_unit', 'test_group', 'test_basic');

    $test->getUnit('unknown');
});

test('get unit group', function () {
    $test = new PropertiesManager();
    $test->registerUnit('test_name','test_unit', 'test_group', 'test_basic');

    expect($test->getUnitGroup('test_name'))->toEqual('test_group');
});

test('get unit basic', function () {
    $test = new PropertiesManager();
    $test->registerUnit('test_name','test_unit', 'test_group', 'test_basic');

    expect($test->getUnitBasic('test_name'))->toEqual('test_basic');
});

test('calculate to basic', function () {
    $test = new PropertiesManager();
    $test->registerUnit('test_basic','test_basicunit', 'test_group');
    $test->registerUnit('test_name','test_unit', 'test_group', 'test_basic',
        function($input) { return $input * 2; },
        function($input) { return $input / 2; } );
    expect($test->calculateToBasic('test_name', 2))->toEqual(4);
});

test('calculate from basic', function () {
    $test = new PropertiesManager();
    $test->registerUnit('test_basic','test_basicunit', 'test_group');
    $test->registerUnit('test_name','test_unit', 'test_group', 'test_basic',
        function($input) { return $input * 2; },
        function($input) { return $input / 2; } );
    expect($test->calculateFromBasic('test_name', 4))->toEqual(2);
});
