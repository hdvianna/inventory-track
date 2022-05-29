<?php

namespace hdvianna\InventoryTrack\UseCases;

use hdvianna\InventoryTrack\Entities\Inventory;

class Result
{
    public function __construct(
        public readonly bool $success,
        public readonly ResultStatus $status,
        public readonly ?Inventory $inventory = null
    ) { }
}