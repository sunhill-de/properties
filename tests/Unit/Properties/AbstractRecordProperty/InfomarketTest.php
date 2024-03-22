<?php

namespace Sunhill\Properties\Tests\Unit\Properties\AbstractRecordProperty;

use Sunhill\Properties\Tests\TestCase;
use Sunhill\Properties\Tests\TestSupport\Properties\NonAbstractRecordProperty;

class InfomarketTest extends TestCase
{
    
    public function testIterate()
    {
        $test = new NonAbstractRecordProperty();

        $element = $test->requestItem(['elementB']);
        
        $this->assertEquals('elementB', $element->getName());
    }
    
}