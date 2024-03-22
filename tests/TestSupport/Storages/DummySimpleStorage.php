<?php

namespace Sunhill\Properties\Tests\TestSupport;

use Sunhill\Properties\Storage\SimpleStorage;

class DummySimpleStorage extends SimpleStorage
{
    protected function readValues(): array
    {
        return ['keyA'=>'ValueA','keyB'=>'ValueB'];
    }
}
