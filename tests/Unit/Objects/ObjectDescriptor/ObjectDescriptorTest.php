<?php

namespace Sunhill\Properties\Tests\Unit\Objects\ObjectDescriptor;

use Sunhill\Properties\Tests\TestCase;
use Sunhill\Properties\Objects\ObjectDescriptor;
use Sunhill\Properties\Facades\Properties;
use Sunhill\Properties\Types\TypeInteger;
use Sunhill\Properties\Objects\Exceptions\MethodNotDefinedException;
use Sunhill\Properties\Properties\RecordProperty;
use Sunhill\Properties\Properties\AbstractProperty;

uses(TestCase::class);

test('Object descriptor calls back record methods', function()
{
    $property = \Mockery::mock(AbstractProperty::class);
    $property->shouldReceive('setMinimum')->with(10)->once();
    $record = \Mockery::mock(RecordProperty::class);
    $record->shouldReceive('appendElement')->once()->with('testint','integer')->andReturn($property);
    
    $test = new ObjectDescriptor($record);    
    $test->integer('testint')->setMinimum(10);
});

test('Object descriptor embed calls record methods', function()
{
    $property = \Mockery::mock(AbstractProperty::class);
    $property->shouldReceive('setMinimum')->with(10)->once();
    $record = \Mockery::mock(RecordProperty::class);
    $record->shouldReceive('embedElement')->once()->with('testint','integer')->andReturn($property);
    
    $test = new ObjectDescriptor($record);
    $test->embed('integer','testint')->setMinimum(10);
});

test('Object descriptor include calls record methods', function()
{
    $property = \Mockery::mock(AbstractProperty::class);
    $property->shouldReceive('setMinimum')->with(10)->once();
    $record = \Mockery::mock(RecordProperty::class);
    $record->shouldReceive('includeElement')->once()->with('testint','integer')->andReturn($property);
    
    $test = new ObjectDescriptor($record);
    $test->include('integer','testint')->setMinimum(10);
});

