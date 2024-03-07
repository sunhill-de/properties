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

namespace Sunhill\ORM\Properties\Semantics;

use Sunhill\ORM\Properties\Types\TypeInteger;

class Capacity extends TypeInteger
{
 
    /**
     * There is no negantive capacity
     */
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
        return 'capacity';
    }
    
    /**
     * Returns some keywords to the current semantic
     *
     * @return array
     */
    public function getSemanticKeywords(): array
    {
        return ['computer'];
    }

    /**
     * Returns the unique id string for the unit of this property
     *
     * @return string
     */
    public function getUnit(): string
    {
        return 'byte';
    }
 
    protected function formatForHuman($input)
    {
        if ($input >= 1000*1000*1000*1000) {
            return round($input/(1000*1000*1000*1000),1).' TB';
        } elseif ($input >= 1000*1000*1000) {
            return round($input/(1000*1000*1000),1).' GB';
        } elseif ($input >= 1000*1000) {
            return round($input/(1000*1000),1).' MB';
        } elseif ($input >= 1000) {
            return round($input/1000,1).' kB';
        } else {
            return $input.' Byte';
        }
    }
}