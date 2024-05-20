<?php

namespace Sunhill\Properties\Tests\Unit\Objects\RecordSetupWorker\Samples;

namespace Sunhill\Properties\Tests\Unit\Managers\Samples;

use Sunhill\Properties\Objects\AbstractPersistantRecord;

class First extends AbstractPersistantRecord
{
    
    public static function getInfo($key, $default = null)
    {
        if ($key !== 'storage_id') {
            throw new \Exception('Unexpected: $key');
        }
        return 'teststorage';
    }
    
    
}