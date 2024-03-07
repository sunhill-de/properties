<?php
/**
 * @file Count.php
 * A semantic class that represents the count of something
 * Lang en
 * Reviewstatus: 2023-05-03
 * Localization: complete
 * Documentation: complete
 * Tests: Unit/Semantic/SemanticTest.php
 * Coverage: unknown
 */

namespace Sunhill\Properties\Semantics;

use Sunhill\Properties\Types\TypeInteger;

class Count extends TypeInteger
{
 
    public function __construct()
    {
        $this->setMinimum(0);
    }
    
    /**
     * Returns the unique id string for the semantic of this property
     *
     * @return string
     */
    public function getSemantic(): string
    {
        return 'count';
    }
    
    /**
     * Returns some keywords to the current semantic
     *
     * @return array
     */
    public function getSemanticKeywords(): array
    {
        return ['count'];
    }
     
}