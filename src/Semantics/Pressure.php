<?php
/**
 * @file Pressure.php
 * Defines a float that represents the pressure of something
 * Lang de,en
 * Reviewstatus: 2024-03-01
 * Localization: complete
 * Documentation: complete
 * Tests: 
 * Coverage: unknown
 */

namespace Sunhill\ORM\Properties\Semantics;

use Sunhill\ORM\Properties\Types\TypeFloat;

class Pressure extends TypeFloat
{
    
    /**
     * Returns the unique id string for the semantic of this property
     *
     * @return string
     */
    public function getSemantic(): string
    {
        return 'pressure';
    }
    
    /**
     * Returns some keywords to the current semantic
     *
     * @return array
     */
    public function getSemanticKeywords(): array
    {
        return ['pressure'];
    }
    
}