<?php

use Sunhill\Properties\Tests\Feature\Properties\SampleCallbackProperty;

uses(\Sunhill\Properties\Tests\TestCase::class);

test('initialize a record with a callback storage and read it', function()
{
    $test = new SampleCallbackProperty();
    $test->setName('TestCallback');
    
    expect($test->sample_string)->toBe('ABC');
});

test('initialize a record with a callback storage and read an array element', function()
{
    $test = new SampleCallbackProperty();
    $test->setName('TestCallback');
    
    expect($test->sample_array[1])->toBe('ABC');
});

test('initialize a record with a callback storage and write to it', function()
{
    $test = new SampleCallbackProperty();
    $test->setName('TestCallback');
    
    $test->sample_integer = 234;
    expect($test->sample_integer)->toBe(234);
});

