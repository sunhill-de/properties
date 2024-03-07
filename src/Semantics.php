<?php 

use Sunhill\ORM\Semantic\Name;
use Sunhill\ORM\Properties\Semantics\FirstName;
use Sunhill\ORM\Properties\Semantics\LastName;
use Sunhill\ORM\Properties\Semantics\Age;
use Sunhill\ORM\Properties\Semantics\Duration;
use Sunhill\ORM\Properties\Semantics\PointInTime;
use Sunhill\ORM\Properties\Semantics\Timestamp;
use Sunhill\ORM\Properties\Semantics\IDString;
use Sunhill\ORM\Properties\Semantics\IPv4Address;
use Sunhill\ORM\Properties\Semantics\IPv6Address;
use Sunhill\ORM\Properties\Semantics\MACAddress;
use Sunhill\ORM\Properties\Semantics\Domain;
use Sunhill\ORM\Properties\Semantics\EMail;
use Sunhill\ORM\Properties\Semantics\URL;

return [
    'age'=>Age::class,
    'domain'=>Domain::class,
    'duration'=>Duration::class,
    'email'=>EMail::class,
    'first_name'=>FirstName::class,
    'idstring'=>IDString::class,
    'ipv4_address'=>IPv4Address::class,
    'ipv6_address'=>IPv6Address::class,
    'last_name'=>LastName::class,
    'mac_address'=>MACAddress::class,
    'name'=>Name::class,
    'pointintime'=>PointInTime::class,
    'timestamp'=>Timestamp::class,
    'url'=>URL::class,
];

?>