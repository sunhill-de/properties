<?php
/**
 * @file Temperature.php
 * Defines a float that represents the temperature of something 
 * Lang de,en
 * Reviewstatus: 2024-03-01
 * Localization: complete
 * Documentation: complete
 * Tests: 
 * Coverage: unknown
 */

namespace Sunhill\ORM\Properties\Semantics;

use Sunhill\ORM\Properties\Types\TypeFloat;

class Airtemperature extends Temperature
{
    
    /**
     * Returns the unique id string for the semantic of this property
     *
     * @return string
     */
    public function getSemantic(): string
    {
        return 'airtemperature';
    }
    
    /**
     * Returns some keywords to the current semantic
     *
     * @return array
     */
    public function getSemanticKeywords(): array
    {
        return ['temperature','weather'];
    }
    
}