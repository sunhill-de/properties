<?php

namespace Sunhill\Properties\Tests\TestSupport\Storages;

use Sunhill\Properties\Storage\SimpleWriteableStorage;

class DummySimpleWriteableStorage extends SimpleWriteableStorage
{
    protected function readValues(): array
    {
        return ['keyA'=>'ValueA','keyB'=>'ValueB'];
    }
}
