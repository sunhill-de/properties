<?php

use Sunhill\Properties\Tests\TestCase;
use Sunhill\Properties\Objects\ObjectDescriptor;
use Sunhill\Properties\Types\TypeInteger;
use Sunhill\Properties\Tests\Unit\Objects\PersistantRecord\Samples\SampleAbstractPersistantRecord;
use Sunhill\Properties\Objects\Exceptions\TypeCannotBeEmbeddedException;

uses(TestCase::class);

test('Persistant record calls initializeProperties', function() 
{
    $integer = \Mockery::mock(TypeInteger::class);
    $descriptor = \Mockery::mock(ObjectDescriptor::class);
    $descriptor->shouldReceive('integer')->with('testint')->andReturn($integer);
    $test = new SampleAbstractPersistantRecord();    
});

test('appendElement() works', function()
{
    
});

test('embedElement() works', function() 
{
    
});

test('embedElement() fails when called with wrong datatype', function()
{
    
})->throws(TypeCannotBeEmbeddedException::class);

test('includeElement() works', function()
{
    
});

test('includeElement() fails when called with wrong datatype', function()
{
    
})->throws(TypeCannotBeEmbeddedException::class);

