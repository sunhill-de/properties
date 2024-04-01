<?php

uses(\Sunhill\Properties\Tests\TestCase::class);
use Sunhill\Properties\Tests\TestSupport\Properties\NonAbstractRecordProperty;
use Sunhill\Properties\Tests\TestSupport\Properties\TraitRecordProperty;
use Sunhill\Properties\Tests\TestSupport\Storages\TestAbstractIDStorage;
test('write and read properties', function () {
    $test = new TraitRecordProperty();
    $storage = new TestAbstractIDStorage();    
    $test->setStorage($storage);
    
    $test->ownelement1 = 'ABC';

    expect($test->ownelement1)->toEqual('ABC');
});

    test('write and read record element', function() {
        $test = new TraitRecordProperty();
        $storage = new TestAbstractIDStorage();
        $test->setStorage($storage);

        $test->ownrecord->elementA = 'DEF';

        expect($test->ownrecord->elementA)->toEqual('DEF');        
    });

    test('write and read trait element', function() {
        $test = new TraitRecordProperty();
        $storage = new TestAbstractIDStorage();
        $test->setStorage($storage);
           
        $test->elementA = 'GHI';
        
        expect($test->elementA)->toEqual('GHI');
    });
            
test('get element names', function () {
    $test = new TraitRecordProperty();

    $elements = $test->getElementNames();

    expect($elements)->toEqual(['ownelement1','ownrecord','elementA','elementB']);
});
test('get own element names', function () {
    $test = new TraitRecordProperty();

    $elements = $test->getOwnElementNames();

    expect($elements)->toEqual(['ownelement1','ownrecord']);
});
test('get elements', function () {
    $test = new TraitRecordProperty();

    $elements = $test->getElements();

    expect($elements[0]->getName())->toEqual('ownelement1');
    expect($elements[2]->getName())->toEqual('elementA');
});

test('get own elements', function () {
    $test = new TraitRecordProperty();

    $elements = $test->getOwnElements();

    expect($elements[0]->getName())->toEqual('ownelement1');
});

test('has elements', function (string $element, bool $has_it = true) {
    $test = new TraitRecordProperty();
    if ($has_it) {
        expect($test->hasElement($element))->toBeTrue();
    } else {
        expect($test->hasElement($element))->not->toBeTrue();        
    }
    expect($test->hasElement('elementA'))->toBeTrue();
    expect($test->hasElement('nonexisting'))->toBeFalse();
})->with([
    'A own property'=>['ownelement1',true],
    'A trait property'=>['elementA',true],
    'A non existing property'=>['nonexisting',false]    
]);