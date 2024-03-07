<?php
/**
 * @file Direction.php
 * A semantic class that represents the direction of somthing regarding the cardinal direction
 * Lang en
 * Reviewstatus: 2023-05-03
 * Localization: complete
 * Documentation: complete
 * Tests: Unit/Semantic/SemanticTest.php
 * Coverage: unknown
 */

namespace Sunhill\ORM\Properties\Semantics;

use Sunhill\ORM\Properties\Types\TypeFloat;

class Direction extends TypeFloat
{
 
    /**
     * There is no negantive capacity
     */
    public function __construct()
    {
        $this->setMinimum(0);
        $this->setMaximum(360);
    }
    
    /**
     * Returns the unique id string for the semantic of this property
     *
     * @return string
     */
    public function getSemantic(): string
    {
        return 'direction';
    }
    
    /**
     * Returns some keywords to the current semantic
     *
     * @return array
     */
    public function getSemanticKeywords(): array
    {
        return ['weather'];
    }

    /**
     * Returns the unique id string for the unit of this property
     *
     * @return string
     */
    public function getUnit(): string
    {
        return 'degree';
    }
 
    protected function formatForHuman($input)
    {
        if ($input < 22.5) {
            return __('N');
        }
        if ($input < 45) {
            return __('NNE');
        }
        if ($input < 67.5) {
            return __('NE');
        }
        if ($input < 90) {
            return __('ENE');
        }
        if ($input < 112.5) {
            return __('E');
        }
        if ($input < 135) {
            return __('ESE');
        }
        if ($input < 157.5) {
            return __('SE');
        }
        if ($input < 180) {
            return __('SSE');
        }
        if ($input < 202.5) {
            return __('S');
        }
        if ($input < 225) {
            return __('SSW');
        }
        if ($input < 247.5) {
            return __('SW');
        }
        if ($input < 270) {
            return __('WSW');
        }
        if ($input < 292.5) {
            return __('W');
        }
        if ($input < 315) {
            return __('WNW');
        }
        if ($input < 337) {
            return __('NW');
        }
        return __('NNW');
    }
}