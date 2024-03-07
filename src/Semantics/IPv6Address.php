<?php
/**
 * @file IPv6Address.php
 * A semantic class for a string that is the ipv6 address of a network device 
 * Lang en
 * Reviewstatus: 2023-05-03
 * Localization: complete
 * Documentation: complete
 * Tests: Unit/Semantic/SemanticTest.php
 * Coverage: unknown
 */

namespace Sunhill\ORM\Properties\Semantics;

class IPv6Address extends NetworkAddress
{
    
    /**
     * Returns the unique id string for the semantic of this property
     *
     * @return string
     */
    public function getSemantic(): string
    {
        return 'ipv6_address';
    }
    
    /**
     * The storage stores a ipv6 address in lower case
     *
     * @param unknown $input
     * @return unknown, by dafult just return the value
     */
    protected function formatForStorage($input)
    {
        return strtolower($input);
    }
    
    /**
     * First check if the given value is an ingteger at all all. afterwards check the boundaries
     *
     * {@inheritDoc}
     * @see \Sunhill\ORM\Properties\ValidatorBase::isValid()
     */
    public function isValid($input): bool
    {
        return filter_var($input, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);
    }
    
}