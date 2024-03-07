<?php
/**
 * @file Airpressure.php
 * Defines a float that represents the air pressure (derrived of pressure) 
 * Lang de,en
 * Reviewstatus: 2024-03-01
 * Localization: complete
 * Documentation: complete
 * Tests: 
 * Coverage: unknown
 */

namespace Sunhill\ORM\Properties\Semantics;

use Sunhill\ORM\Properties\Types\TypeFloat;

class Airpressure extends Pressure
{
    
    /**
     * Returns the unique id string for the semantic of this property
     *
     * @return string
     */
    public function getSemantic(): string
    {
        return 'airpressure';
    }
    
    /**
     * Returns some keywords to the current semantic
     *
     * @return array
     */
    public function getSemanticKeywords(): array
    {
        return ['pressure','weather'];
    }
    
}