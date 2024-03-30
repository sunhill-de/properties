<?php

uses(\Sunhill\Properties\Tests\TestCase::class);
use Sunhill\Properties\Storage\Exceptions\FieldNotAvaiableException;
use Sunhill\Properties\Tests\TestSupport\Storages\DummyCallbackStorage;


test('read value', function () {
    $test = new DummyCallbackStorage();
    expect($test->getValue('readonly'))->toEqual('ABC');
});

test('read unknown value', function () {
    $this->expectException(FieldNotAvaiableException::class);

    $test = new DummyCallbackStorage();
    $help = $test->getValue('NonExisting');
});

test('get readable on readonly', function () {
    $test = new DummyCallbackStorage();

    expect($test->getIsReadable('readonly'))->toBeTrue();
});

test('get writeable on readonly', function () {
    $test = new DummyCallbackStorage();

    expect($test->getIsWriteable('readonly'))->toBeFalse();
});

test('write readonly', function () {
    $this->expectException(FieldNotAvaiableException::class);

    $test = new DummyCallbackStorage();
    $test->setValue('readonly', 'RRR');
});

test('empty caps on readonly', function () {
    $test = new DummyCallbackStorage();

    expect($test->getReadCapability('readonly'))->toBeNull();
});

test('read read write', function () {
    $test = new DummyCallbackStorage();
    expect($test->getValue('readwrite'))->toEqual('DEF');
});

test('write read write', function () {
    $test = new DummyCallbackStorage();
    $test->setValue('readwrite','ZZZ');
    expect($test->readwrite)->toEqual('ZZZ');
});

test('get readable on readwrite', function () {
    $test = new DummyCallbackStorage();

    expect($test->getIsReadable('readwrite'))->toBeTrue();
});

test('get writeable on readwrite', function () {
    $test = new DummyCallbackStorage();

    expect($test->getIsWriteable('readwrite'))->toBeTrue();
});

test('get capabilities on restricted', function () {
    $test = new DummyCallbackStorage();

    expect($test->getWriteCapability('restricted'))->toEqual('write_cap');
});

test('initialize', function () {
    $test = new DummyCallbackStorage();

    expect($test->getIsInitialized('uninitialized'))->toBeFalse();
    $test->setValue('uninitialized','GHI');
    expect($test->getIsInitialized('uninitialized'))->toBeTrue();
    expect($test->uninitialized)->toEqual('GHI');
});
