<?php

namespace hdvianna\InventoryTrack\UseCases;

use hdvianna\InventoryTrack\Adapters\InventoryAdapter;
use hdvianna\InventoryTrack\Entities\Inventory;
use hdvianna\InventoryTrack\Repositories\InventoryRepository;
use hdvianna\InventoryTrack\UseCases\Results\ManageInventoryResult;
use hdvianna\InventoryTrack\UseCases\Results\Statuses\ManageInventoryResultStatus;

class ManageInventory
{
    public function __construct(
        private InventoryRepository $inventoryRepository,
    ) {}

    public function create(InventoryAdapter $inventoryAdapter) : ManageInventoryResult {
        $serialNumber = $inventoryAdapter->getSerialNumber();
        $oldInventory = $this->inventoryRepository->findBySerialNumber($serialNumber);
        if (is_null($oldInventory)) {
            $newInventory = new Inventory($inventoryAdapter->getName(), $serialNumber, $inventoryAdapter->getValue());
            $this->inventoryRepository->insert($newInventory);
            return new ManageInventoryResult(true, ManageInventoryResultStatus::CreationSuccess, $newInventory);
        } else {
            return new ManageInventoryResult(false, ManageInventoryResultStatus::CreationFailedInventoryAlreadyExists, null);
        }
    }

}