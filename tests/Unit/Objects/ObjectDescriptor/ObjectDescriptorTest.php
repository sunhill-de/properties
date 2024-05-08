<?php

namespace Sunhill\Properties\Tests\Unit\Objects\ObjectDescriptor;

use Sunhill\Properties\Tests\TestCase;
use Sunhill\Properties\Objects\ObjectDescriptor;
use Sunhill\Properties\Facades\Properties;
use Sunhill\Properties\Types\TypeInteger;
use Sunhill\Properties\Objects\Exceptions\MethodNotDefinedException;

uses(TestCase::class);

test('Object descriptor calls property manager', function()
{
    $test = new ObjectDescriptor();
    Properties::shouldReceive('propertyExists')->once()->with('integer')->andReturn(true);
    Properties::shouldReceive('propertyHasMethod')->once()->with('integer','setName')->andReturn(true);
    Properties::shouldReceive('propertyHasMethod')->once()->with('integer','setMinimum')->andReturn(true);
    Properties::shouldReceive('propertyHasMethod')->once()->with('integer','setMaximum')->andReturn(true);
    $test->integer('testint')->setMinimum(10)->setMaximum(20);
    expect($test->testint->name)->toBe('testint');
    expect($test->testint->setMimimum)->toBe(10);
    expect($test->testint->setMaximum)->toBe(20);
});

test('Object descriptor calls own methods', function()
{
    $test = new ObjectDescriptor();
    Properties::shouldReceive('propertyExists')->once()->with('integer')->andReturn(true);
    Properties::shouldReceive('propertyHasMethod')->once()->with('integer','embed')->andReturn(false);
    $test->integer('testint')->embed();
    expect($test->testint->inclusion)->toBe('embedded');
});

it('raises exception when neither property method nor own method exist', function()
{
    $test = new ObjectDescriptor();
    Properties::shouldReceive('propertyExists')->once()->with('integer')->andReturn(true);
    Properties::shouldReceive('propertyHasMethod')->once()->with('integer','setNonexisting')->andReturn(false);
    $test->integer('testint')->setNonexisting('something');
})->throws(MethodNotDefinedException::class);