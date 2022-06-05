<?php

namespace hdvianna\InventoryTrack\UseCases\Results;

use hdvianna\InventoryTrack\Entities\Inventory;
use hdvianna\InventoryTrack\UseCases\Results\Statuses\ManageInventoryResultStatus;

/** @psalm-immutable */
class ManageInventoryResult
{
    public function __construct(
        public readonly bool                        $success,
        public readonly ManageInventoryResultStatus $status,
        public readonly ?Inventory                  $inventory = null
    ) { }
}