<?php

use Sunhill\Properties\Objects\PropertyList;

uses(\Sunhill\Properties\Tests\TestCase::class);

test('property catch all pass', function() {
   $test = new PropertyList();
   $test->integer('test_integer');
   expect($test->hasProperty('test_integer'))->toBe(true);
});