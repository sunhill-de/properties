<?php
/**
 * @file IPv4Address.php
 * A semantic class for a string that is the ipv4 address of a network device 
 * Lang en
 * Reviewstatus: 2023-05-03
 * Localization: complete
 * Documentation: complete
 * Tests: Unit/Semantic/SemanticTest.php
 * Coverage: unknown
 */

namespace Sunhill\Properties\Semantics;

class IPv4Address extends NetworkAddress
{
    
    /**
     * Returns the unique id string for the semantic of this property
     *
     * @return string
     */
    public function getSemantic(): string
    {
        return 'ipv4_address';
    }
    
    
    /**
     * First check if the given value is an ingteger at all all. afterwards check the boundaries
     *
     * {@inheritDoc}
     * @see \Sunhill\Properties\\ValidatorBase::isValid()
     */
    public function isValid($input): bool
    {
        return filter_var($input, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }
    
}