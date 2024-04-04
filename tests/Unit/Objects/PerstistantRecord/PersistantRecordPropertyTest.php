<?php

use Sunhill\Properties\Tests\Unit\Objects\TestObjects\DummyPersistantRecord;
use Sunhill\Properties\Storage\AbstractStorage;

uses(\Sunhill\Properties\Tests\TestCase::class);

test('setupProperties is called', function() {
   $test = new DummyPersistantRecord();
   expect($test->hasElement('dummyint'))->toBe(true);
});

test('properties are accessible', function() {
    $storage = Mockery::mock(AbstractStorage::class);
    $storage->shouldReceive('setValue')->with('dummyint',12);
    $storage->shouldReceive('getIsInitialized')->with('dummyint')->andReturn(true);
    $storage->shouldReceive('getIsWriteable')->with('dummyint')->andReturn(true);
    $storage->shouldReceive('getIsReadable')->with('dummyint')->andReturn(true);
    $storage->shouldReceive('getModifyCapability')->with('dummyint')->andReturn(null);
    $storage->shouldReceive('getReadCapability')->with('dummyint')->andReturn(null);
    $storage->shouldReceive('getValue')->with('dummyint')->andReturn(12);
    
    $test = new DummyPersistantRecord();
    $test->setStorage($storage);
    
    $test->dummyint = 12;
    expect($test->dummyint)->toBe(12);    
});