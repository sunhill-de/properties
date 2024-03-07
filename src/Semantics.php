<?php 

use Sunhill\Properties\Semantic\Name;
use Sunhill\Properties\Properties\Semantics\FirstName;
use Sunhill\Properties\Properties\Semantics\LastName;
use Sunhill\Properties\Properties\Semantics\Age;
use Sunhill\Properties\Properties\Semantics\Duration;
use Sunhill\Properties\Properties\Semantics\PointInTime;
use Sunhill\Properties\Properties\Semantics\Timestamp;
use Sunhill\Properties\Properties\Semantics\IDString;
use Sunhill\Properties\Properties\Semantics\IPv4Address;
use Sunhill\Properties\Properties\Semantics\IPv6Address;
use Sunhill\Properties\Properties\Semantics\MACAddress;
use Sunhill\Properties\Properties\Semantics\Domain;
use Sunhill\Properties\Properties\Semantics\EMail;
use Sunhill\Properties\Properties\Semantics\URL;

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