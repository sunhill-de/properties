<?php
/**
 * @file MD5.php
 * A semantic class for an md5 string 
 * Lang en
 * Reviewstatus: 2023-05-03
 * Localization: complete
 * Documentation: complete
 * Tests: Unit/Semantic/SemanticTest.php
 * Coverage: unknown
 */

namespace Sunhill\ORM\Properties\Semantics;

class MD5 extends IDString
{
    
    /**
     * Returns the unique id string for the semantic of this property
     *
     * @return string
     */
    public function getSemantic(): string
    {
        return 'md5';
    }
    
    /**
     * Returns some keywords to the current semantic
     *
     * @return array
     */
    public function getSemanticKeywords(): array
    {
        return ['id','computer'];
    }
  
    /**
     * The storage stores a mac address in lower case
     *
     * @param unknown $input
     * @return unknown, by dafult just return the value
     */
    protected function formatForStorage($input)
    {
        return strtolower($input);
    }
    
    /**
     * Checks if the given string is a valid email address
     *
     * {@inheritDoc}
     * @see \Sunhill\ORM\Properties\ValidatorBase::isValid()
     */
    public function isValid($input): bool
    {
        return preg_match('/^[a-f0-9]{32}$/', $input);
    }
    
}