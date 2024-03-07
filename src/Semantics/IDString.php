<?php
/**
 * @file IDString.php
 * A semantic class for a string that is a id of something 
 * Lang en
 * Reviewstatus: 2023-05-03
 * Localization: complete
 * Documentation: complete
 * Tests: Unit/Semantic/SemanticTest.php
 * Coverage: unknown
 */

namespace Sunhill\ORM\Properties\Semantics;

use Sunhill\ORM\Properties\Types\TypeVarchar;

class IDString extends TypeVarchar
{
    
    /**
     * Returns the unique id string for the semantic of this property
     *
     * @return string
     */
    public function getSemantic(): string
    {
        return 'idstring';
    }
    
    /**
     * Returns some keywords to the current semantic
     *
     * @return array
     */
    public function getSemanticKeywords(): array
    {
        return ['id'];
    }
     
}