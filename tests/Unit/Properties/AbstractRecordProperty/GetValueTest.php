<?php

use Sunhill\Properties\Tests\TestCase;
use Sunhill\Properties\Tests\TestSupport\NonAbstractRecordProperty;
use Sunhill\Properties\Tests\TestSupport\NonAbstractProperty;
use Sunhill\Properties\Facades\Properties;
use Sunhill\Properties\Properties\Exceptions\CantProcessPropertyException;
use Sunhill\Properties\Properties\AbstractSimpleProperty;
use Sunhill\Properties\Properties\AbstractRecordProperty;

class GetValueProperty extends AbstractSimpleProperty
{
    
    public $value = 5;
    
    public function isValid($value): bool
    {
        return true;
    }
    
    public function getAccessType(): string
    {
        return 'integer';
    }

    public function getValue()
    {
        return $this->value;
    }
    
    public function setValue($value)
    {
        $this->value = $value;
    }
}

class GetValueRecordProperty extends AbstractRecordProperty
{
    public function isValid($test): bool
    {
        return false;
    }
    
    protected function initializeElements()
    {
        $element1 = new GetValueProperty();
        $element1->setName('elementA');
        $element1->setOwner($this);
        
        $element2 = new GetValueProperty();
        $element2->setName('elementB');
        $element2->setOwner($this);
        
        $this->elements['elementA'] = $element1;
        $this->elements['elementB'] = $element2;
    }
        
}

class GetValueTest extends TestCase
{
    
    public function testGetValue()
    {
        $test = new GetValueRecordProperty();
        
        $this->assertEquals(5, $test->elementA);
    }
    
    public function testSetValue()
    {
        $test = new GetValueRecordProperty();
        $test->elementA = 55;
        
        $this->assertEquals(55, $test->elementA);
        $this->assertEquals(5, $test->elementB);
        
    }
}