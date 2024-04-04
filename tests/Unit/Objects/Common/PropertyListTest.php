<?php

use Sunhill\Properties\Objects\PropertyList;
use Sunhill\Properties\Facades\Properties;
use Sunhill\Properties\Types\TypeInteger;
use Sunhill\Properties\Properties\Exceptions\DuplicateElementNameException;
use Sunhill\Properties\Types\TypeVarchar;

uses(\Sunhill\Properties\Tests\TestCase::class);

test('property catch all pass', function() {
   Properties::shouldReceive('getNamespaceOfProperty')
     ->with('integer')->once()->andReturn(TypeInteger::class);
   $test = new PropertyList();
   $test->integer('test_integer');
   expect($test->hasProperty('test_integer'))->toBe(true);
});

it('throws an exception when name is duplicate', function() {
   Properties::shouldReceive('getNamespaceOfProperty')
    ->with('integer')->once()->andReturn(TypeInteger::class);
   Properties::shouldReceive('getNamespaceOfProperty')
    ->with('varchar')->once()->andReturn(TypeVarchar::class);
   $test = new PropertyList();
   $test->integer('test_integer');
   $test->varchar('test_integer');
})->throws(DuplicateElementNameException::class);
        
test('iterate through elements', function() {
    Properties::shouldReceive('getNamespaceOfProperty')
    ->with('integer')->once()->andReturn(TypeInteger::class);
    Properties::shouldReceive('getNamespaceOfProperty')
    ->with('varchar')->once()->andReturn(TypeVarchar::class);
    $test = new PropertyList();
    $test->integer('test_integer');
    $test->varchar('test_string');
    
    $result = '';
    foreach ($test as $key => $value) {
        $result .= $key.'=>'.$value->getName();
    }
    expect($result)->toBe('test_integer=>test_integertest_string=>test_string');
});        