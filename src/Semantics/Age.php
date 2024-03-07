<?php
/**
 * @file Age.php
 * A semantic class for describing the age of a person or thing
 * Lang en
 * Reviewstatus: 2023-05-03
 * Localization: complete
 * Documentation: complete
 * Tests: Unit/Semantic/SemanticTest.php
 * Coverage: unknown
 */

namespace Sunhill\ORM\Properties\Semantics;

use Sunhill\ORM\Properties\Types\TypeInteger;

class Age extends TypeInteger
{
    
    /**
     * Returns the unique id string for the semantic of this property
     *
     * @return string
     */
    public function getSemantic(): string
    {
        return 'age';
    }
    
    /**
     * Returns some keywords to the current semantic
     *
     * @return array
     */
    public function getSemanticKeywords(): array
    {
        return ['time'];
    }
 
    /**
     * Returns the unique id string for the unit of this property
     *
     * @return string
     */
    public function getUnit(): string
    {
        return 'second';
    }
    
}