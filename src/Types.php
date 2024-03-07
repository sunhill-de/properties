<?php 
use Sunhill\Properties\Properties\Types\TypeVarchar;
use Sunhill\Properties\Properties\Types\TypeInteger;
use Sunhill\Properties\Properties\Types\TypeBoolean;
use Sunhill\Properties\Properties\Types\TypeDate;
use Sunhill\Properties\Properties\Types\TypeDateTime;
use Sunhill\Properties\Properties\Types\TypeEnum;
use Sunhill\Properties\Properties\Types\TypeFloat;
use Sunhill\Properties\Properties\Types\TypeText;
use Sunhill\Properties\Properties\Types\TypeTime;

return [
    'boolean'=>TypeBoolean::class,
    'bool'=>TypeBoolean::class,
    'date'=>TypeDate::class,
    'datetime'=>TypeDateTime::class,
    'enum'=>TypeEnum::class,
    'float'=>TypeFloat::class,
    'int'=>TypeInteger::class,
    'integer'=>TypeInteger::class,
    'text'=>TypeText::class,
    'time'=>TypeTime::class,
    'varchar'=>TypeVarchar::class,
    'string'=>TypeVarchar::class,
    
];

?>