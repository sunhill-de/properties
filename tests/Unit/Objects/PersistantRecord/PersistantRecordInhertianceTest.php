<?php

use Sunhill\Properties\Tests\TestCase;
use Sunhill\Properties\Types\TypeInteger;
use Sunhill\Properties\Objects\Exceptions\TypeCannotBeEmbeddedException;
use Sunhill\Properties\Tests\Unit\Objects\PersistantRecord\Samples\EmptyPersistantRecord;
use Sunhill\Properties\Facades\Properties;
use Sunhill\Properties\Properties\AbstractRecordProperty;
use Sunhill\Properties\Types\TypeVarchar;
use Sunhill\Properties\Objects\Exceptions\TypeAlreadyEmbeddedException;
use Sunhill\Properties\Properties\Exceptions\DuplicateElementNameException;
use Sunhill\Properties\Storage\AbstractStorage;
use Sunhill\Properties\Tests\Unit\Objects\PersistantRecord\Samples\ParentRecord;
use Sunhill\Properties\Tests\Unit\Objects\PersistantRecord\Samples\ChildRecord;
use Sunhill\Properties\Tests\Unit\Objects\PersistantRecord\Samples\GrandChildRecord;
use Sunhill\Properties\Tests\Unit\Objects\PersistantRecord\Samples\EmptyChildRecord;
use Sunhill\Properties\Tests\Unit\Objects\PersistantRecord\Samples\EmptyGrandChildRecord;
use Sunhill\Properties\Properties\AbstractProperty;

uses(TestCase::class);

test('Parent has element while including', function()
{
    Properties::shouldReceive('createProperty')->with('ParentRecord')->andReturn(new ParentRecord());
    ParentRecord::$handle_inheritance = 'include';
   $test = new ParentRecord();
   
   expect($test->hasElement('parentint'))->toBe(true);
   expect($test->hasElement('nonexisting'))->toBe(false);
   expect($test->hasElement('childvarchar'))->toBe(false);
   expect($test->hasElement('grandchildfloat'))->toBe(false);
});

test('Parent exports element while including', function()
{
    Properties::shouldReceive('createProperty')->with('ParentRecord')->andReturn(new ParentRecord());
    ParentRecord::$handle_inheritance = 'include';
    $test = new ParentRecord();
    $elements = $test->exportElements();
   
    expect(isset($elements['parentrecords']))->toBe(true);
    expect(isset($elements['parentrecords']['parentint']))->toBe(true);
    expect($elements['parentrecords']['parentint'])->toBe('simple');
});

test('Child has element while including', function()
{
    Properties::shouldReceive('createProperty')->with('ParentRecord')->andReturn(new ParentRecord());
    Properties::shouldReceive('createProperty')->with('ChildRecord')->andReturn(new ChildRecord());
    ParentRecord::$handle_inheritance = 'include';
    $test = new ChildRecord();
    expect($test->hasElement('parentint'))->toBe(true);
    expect($test->hasElement('childvarchar'))->toBe(true);
    expect($test->hasElement('grandchildfloat'))->toBe(false);
});

test('Child exports element while including', function()
{
    Properties::shouldReceive('createProperty')->with('ParentRecord')->andReturn(new ParentRecord());
    ParentRecord::$handle_inheritance = 'include';
    Properties::shouldReceive('createProperty')->with('ChildRecord')->andReturn(new ChildRecord());
    $test = new ChildRecord();
    $elements = $test->exportElements();
    
    expect(isset($elements['parentrecords']))->toBe(true);
    expect(isset($elements['parentrecords']['parentint']))->toBe(true);
    expect($elements['parentrecords']['parentint'])->toBe('simple');
    expect(isset($elements['parentrecords']['childvarchar']))->toBe(true);
    expect($elements['parentrecords']['childvarchar'])->toBe('simple');
});

test('Empty child has element while including', function()
{
    Properties::shouldReceive('createProperty')->with('ParentRecord')->andReturn(new ParentRecord());
    Properties::shouldReceive('createProperty')->with('EmptyChildRecord')->andReturn(new EmptyChildRecord());
    ParentRecord::$handle_inheritance = 'include';
    $test = new EmptyChildRecord();
    expect($test->hasElement('parentint'))->toBe(true);
    expect($test->hasElement('childvarchar'))->toBe(false);
    expect($test->hasElement('grandchildfloat'))->toBe(false);
});

test('Empty child exports element while including', function()
{
    Properties::shouldReceive('createProperty')->with('ParentRecord')->andReturn(new ParentRecord());
    Properties::shouldReceive('createProperty')->with('EmptyChildRecord')->andReturn(new EmptyChildRecord());
    ParentRecord::$handle_inheritance = 'include';
    $test = new EmptyChildRecord();
    $elements = $test->exportElements();
    
    expect(isset($elements['parentrecords']))->toBe(true);
    expect(isset($elements['parentrecords']['parentint']))->toBe(true);
    expect($elements['parentrecords']['parentint'])->toBe('simple');
});

test('Grandchild has element while including', function()
{
    Properties::shouldReceive('createProperty')->with('ParentRecord')->andReturn(new ParentRecord());
    Properties::shouldReceive('createProperty')->with('ChildRecord')->andReturn(new ChildRecord());
    Properties::shouldReceive('createProperty')->with('GrandChildRecord')->andReturn(new GrandChildRecord());
    ParentRecord::$handle_inheritance = 'include';
    $test = new GrandChildRecord();
    expect($test->hasElement('parentint'))->toBe(true);
    expect($test->hasElement('childvarchar'))->toBe(true);
    expect($test->hasElement('grandchildfloat'))->toBe(true);
});

test('Grandchild exports element while including', function()
{
    Properties::shouldReceive('createProperty')->with('ParentRecord')->andReturn(new ParentRecord());
    Properties::shouldReceive('createProperty')->with('ChildRecord')->andReturn(new ChildRecord());
    Properties::shouldReceive('createProperty')->with('GrandChildRecord')->andReturn(new GrandChildRecord());
    ParentRecord::$handle_inheritance = 'include';
    $test = new GrandChildRecord();
    $elements = $test->exportElements();
    
    expect(isset($elements['parentrecords']))->toBe(true);
    expect(isset($elements['parentrecords']['parentint']))->toBe(true);
    expect($elements['parentrecords']['parentint'])->toBe('simple');
    expect(isset($elements['parentrecords']['childvarchar']))->toBe(true);
    expect($elements['parentrecords']['childvarchar'])->toBe('simple');
    expect(isset($elements['parentrecords']['grandchildfloat']))->toBe(true);
    expect($elements['parentrecords']['grandchildfloat'])->toBe('simple');
});

test('Empty Grandchild has element while including', function()
{
    Properties::shouldReceive('createProperty')->with('ParentRecord')->andReturn(new ParentRecord());
    Properties::shouldReceive('createProperty')->with('EmptyChildRecord')->andReturn(new EmptyChildRecord());
    Properties::shouldReceive('createProperty')->with('EmptyGrandChildRecord')->andReturn(new EmptyGrandChildRecord());
    ParentRecord::$handle_inheritance = 'include';
    $test = new EmptyGrandChildRecord();
    expect($test->hasElement('parentint'))->toBe(true);
    expect($test->hasElement('childvarchar'))->toBe(false);
    expect($test->hasElement('grandchildfloat'))->toBe(true);
});

test('Empty grandchild exports element while including', function()
{
    Properties::shouldReceive('createProperty')->with('ParentRecord')->andReturn(new ParentRecord());
    Properties::shouldReceive('createProperty')->with('EmptyChildRecord')->andReturn(new EmptyChildRecord());
    Properties::shouldReceive('createProperty')->with('EmptyGrandChildRecord')->andReturn(new EmptyGrandChildRecord());
    ParentRecord::$handle_inheritance = 'include';
    $test = new EmptyGrandChildRecord();
    $elements = $test->exportElements();
    
    expect(isset($elements['parentrecords']))->toBe(true);
    expect(isset($elements['parentrecords']['parentint']))->toBe(true);
    expect($elements['parentrecords']['parentint'])->toBe('simple');
    expect(isset($elements['parentrecords']['grandchildfloat']))->toBe(true);
    expect($elements['parentrecords']['grandchildfloat'])->toBe('simple');
});

test('Parent has element while embedding', function()
{
    Properties::shouldReceive('createProperty')->with('ParentRecord')->andReturn(new ParentRecord());
    Properties::shouldReceive('createProperty')->with('ChildRecord')->andReturn(new ChildRecord());
    Properties::shouldReceive('createProperty')->with('GrandChildRecord')->andReturn(new GrandChildRecord());
    Properties::shouldReceive('createProperty')->with('EmptyChildRecord')->andReturn(new EmptyChildRecord());
    Properties::shouldReceive('createProperty')->with('EmptyGrandChildRecord')->andReturn(new EmptyGrandChildRecord());
    ParentRecord::$handle_inheritance = 'embed';
    $test = new ParentRecord();
    expect($test->hasElement('parentint'))->toBe(true);
    expect($test->hasElement('nonexisting'))->toBe(false);
    expect($test->hasElement('childvarchar'))->toBe(false);
    expect($test->hasElement('grandchildfloat'))->toBe(false);
});

test('parent exports element while embedding', function()
{
    Properties::shouldReceive('createProperty')->with('ParentRecord')->andReturn(new ParentRecord());
    Properties::shouldReceive('createProperty')->with('ChildRecord')->andReturn(new ChildRecord());
    Properties::shouldReceive('createProperty')->with('GrandChildRecord')->andReturn(new GrandChildRecord());
    Properties::shouldReceive('createProperty')->with('EmptyChildRecord')->andReturn(new EmptyChildRecord());
    Properties::shouldReceive('createProperty')->with('EmptyGrandChildRecord')->andReturn(new EmptyGrandChildRecord());
    ParentRecord::$handle_inheritance = 'embed';
    $test = new ParentRecord();
    $elements = $test->exportElements();
    
    expect(isset($elements['parentrecords']))->toBe(true);
    expect(isset($elements['parentrecords']['parentint']))->toBe(true);
    expect($elements['parentrecords']['parentint'])->toBe('simple');
});

test('Child has element while embedding', function()
{
    Properties::shouldReceive('createProperty')->with('ParentRecord')->andReturn(new ParentRecord());
    Properties::shouldReceive('createProperty')->with('ChildRecord')->andReturn(new ChildRecord());
    Properties::shouldReceive('createProperty')->with('GrandChildRecord')->andReturn(new GrandChildRecord());
    Properties::shouldReceive('createProperty')->with('EmptyChildRecord')->andReturn(new EmptyChildRecord());
    Properties::shouldReceive('createProperty')->with('EmptyGrandChildRecord')->andReturn(new EmptyGrandChildRecord());
    ParentRecord::$handle_inheritance = 'embed';
    $test = new ChildRecord();
    expect($test->hasElement('parentint'))->toBe(true);
    expect($test->hasElement('childvarchar'))->toBe(true);
    expect($test->hasElement('grandchildfloat'))->toBe(false);
});

test('child exports element while embedding', function()
{
    Properties::shouldReceive('createProperty')->with('ParentRecord')->andReturn(new ParentRecord());
    Properties::shouldReceive('createProperty')->with('ChildRecord')->andReturn(new ChildRecord());
    Properties::shouldReceive('createProperty')->with('GrandChildRecord')->andReturn(new GrandChildRecord());
    Properties::shouldReceive('createProperty')->with('EmptyChildRecord')->andReturn(new EmptyChildRecord());
    Properties::shouldReceive('createProperty')->with('EmptyGrandChildRecord')->andReturn(new EmptyGrandChildRecord());
    ParentRecord::$handle_inheritance = 'embed';
    $test = new ChildRecord();
    $elements = $test->exportElements();
    
    expect(isset($elements['parentrecords']))->toBe(true);
    expect(isset($elements['parentrecords']['parentint']))->toBe(true);
    expect($elements['parentrecords']['parentint'])->toBe('simple');
    expect(isset($elements['childrecords']))->toBe(true);
    expect(isset($elements['childrecords']['childvarchar']))->toBe(true);
    expect($elements['childrecords']['childvarchar'])->toBe('simple');
});


test('Empty child has element while embedding', function()
{
    Properties::shouldReceive('createProperty')->with('ParentRecord')->andReturn(new ParentRecord());
    Properties::shouldReceive('createProperty')->with('ChildRecord')->andReturn(new ChildRecord());
    Properties::shouldReceive('createProperty')->with('GrandChildRecord')->andReturn(new GrandChildRecord());
    Properties::shouldReceive('createProperty')->with('EmptyChildRecord')->andReturn(new EmptyChildRecord());
    Properties::shouldReceive('createProperty')->with('EmptyGrandChildRecord')->andReturn(new EmptyGrandChildRecord());
    ParentRecord::$handle_inheritance = 'embed';
    $test = new EmptyChildRecord();
    expect($test->hasElement('parentint'))->toBe(true);
    expect($test->hasElement('childvarchar'))->toBe(false);
    expect($test->hasElement('grandchildfloat'))->toBe(false);
});

test('Empty child exports element while embedding', function()
{
    Properties::shouldReceive('createProperty')->with('ParentRecord')->andReturn(new ParentRecord());
    Properties::shouldReceive('createProperty')->with('ChildRecord')->andReturn(new ChildRecord());
    Properties::shouldReceive('createProperty')->with('GrandChildRecord')->andReturn(new GrandChildRecord());
    Properties::shouldReceive('createProperty')->with('EmptyChildRecord')->andReturn(new EmptyChildRecord());
    Properties::shouldReceive('createProperty')->with('EmptyGrandChildRecord')->andReturn(new EmptyGrandChildRecord());
    ParentRecord::$handle_inheritance = 'embed';
    $test = new EmptyChildRecord();
    $elements = $test->exportElements();
    
    expect(isset($elements['parentrecords']))->toBe(true);
    expect(isset($elements['parentrecords']['parentint']))->toBe(true);
    expect($elements['parentrecords']['parentint'])->toBe('simple');
    expect(isset($elements['childrecords']))->toBe(true);
});


test('Grandchild has element while embedding', function()
{
    Properties::shouldReceive('createProperty')->with('ParentRecord')->andReturn(new ParentRecord());
    Properties::shouldReceive('createProperty')->with('ChildRecord')->andReturn(new ChildRecord());
    Properties::shouldReceive('createProperty')->with('GrandChildRecord')->andReturn(new GrandChildRecord());
    Properties::shouldReceive('createProperty')->with('EmptyChildRecord')->andReturn(new EmptyChildRecord());
    Properties::shouldReceive('createProperty')->with('EmptyGrandChildRecord')->andReturn(new EmptyGrandChildRecord());
    ParentRecord::$handle_inheritance = 'embed';
    $test = new GrandChildRecord();
    expect($test->hasElement('parentint'))->toBe(true);
    expect($test->hasElement('childvarchar'))->toBe(true);
    expect($test->hasElement('grandchildfloat'))->toBe(true);
});

test('grandchild exports element while embedding', function()
{
    Properties::shouldReceive('createProperty')->with('ParentRecord')->andReturn(new ParentRecord());
    Properties::shouldReceive('createProperty')->with('ChildRecord')->andReturn(new ChildRecord());
    Properties::shouldReceive('createProperty')->with('GrandChildRecord')->andReturn(new GrandChildRecord());
    Properties::shouldReceive('createProperty')->with('EmptyChildRecord')->andReturn(new EmptyChildRecord());
    Properties::shouldReceive('createProperty')->with('EmptyGrandChildRecord')->andReturn(new EmptyGrandChildRecord());
    ParentRecord::$handle_inheritance = 'embed';
    $test = new GrandChildRecord();
    $elements = $test->exportElements();
    
    expect(isset($elements['parentrecords']))->toBe(true);
    expect(isset($elements['parentrecords']['parentint']))->toBe(true);
    expect($elements['parentrecords']['parentint'])->toBe('simple');
    expect(isset($elements['childrecords']))->toBe(true);
    expect(isset($elements['childrecords']['childvarchar']))->toBe(true);
    expect($elements['childrecords']['childvarchar'])->toBe('simple');
    expect(isset($elements['grandchildrecords']))->toBe(true);
    expect(isset($elements['grandchildrecords']['grandchildfloat']))->toBe(true);
    expect($elements['grandchildrecords']['grandchildfloat'])->toBe('simple');
});


test('Empty Grandchild has element while embedding', function()
{
    Properties::shouldReceive('createProperty')->with('ParentRecord')->andReturn(new ParentRecord());
    Properties::shouldReceive('createProperty')->with('ChildRecord')->andReturn(new ChildRecord());
    Properties::shouldReceive('createProperty')->with('GrandChildRecord')->andReturn(new GrandChildRecord());
    Properties::shouldReceive('createProperty')->with('EmptyChildRecord')->andReturn(new EmptyChildRecord());
    Properties::shouldReceive('createProperty')->with('EmptyGrandChildRecord')->andReturn(new EmptyGrandChildRecord());
    ParentRecord::$handle_inheritance = 'embed';
    $test = new EmptyGrandChildRecord();
    expect($test->hasElement('parentint'))->toBe(true);
    expect($test->hasElement('childvarchar'))->toBe(false);
    expect($test->hasElement('grandchildfloat'))->toBe(true);
});

test('Empty grandchild exports element while embedding', function()
{
    Properties::shouldReceive('createProperty')->with('ParentRecord')->andReturn(new ParentRecord());
    Properties::shouldReceive('createProperty')->with('ChildRecord')->andReturn(new ChildRecord());
    Properties::shouldReceive('createProperty')->with('GrandChildRecord')->andReturn(new GrandChildRecord());
    Properties::shouldReceive('createProperty')->with('EmptyChildRecord')->andReturn(new EmptyChildRecord());
    Properties::shouldReceive('createProperty')->with('EmptyGrandChildRecord')->andReturn(new EmptyGrandChildRecord());
    ParentRecord::$handle_inheritance = 'embed';
    $test = new EmptyGrandChildRecord();
    $elements = $test->exportElements();
    
    expect(isset($elements['parentrecords']))->toBe(true);
    expect(isset($elements['parentrecords']['parentint']))->toBe(true);
    expect($elements['parentrecords']['parentint'])->toBe('simple');
    expect(isset($elements['childrecords']))->toBe(true);
    expect(isset($elements['childrecords']['childvarchar']))->toBe(false);
    expect(isset($elements['grandchildrecords']))->toBe(true);
    expect(isset($elements['grandchildrecords']['grandchildfloat']))->toBe(true);
    expect($elements['grandchildrecords']['grandchildfloat'])->toBe('simple');
});


