<?php

namespace hdvianna\InventoryTrack\UseCases;

use hdvianna\InventoryTrack\Adapters\InventoryAdapter;
use hdvianna\InventoryTrack\Entities\Inventory;
use hdvianna\InventoryTrack\Repositories\InventoryRepository;

class ManageInventory
{
    public function __construct(
        private InventoryRepository $inventoryRepository,
    ) {}

    public function create(InventoryAdapter $inventoryAdapter) : Result {
        $serialNumber = $inventoryAdapter->getSerialNumber();
        $oldInventory = $this->inventoryRepository->findBySerialNumber($serialNumber);
        if (is_null($oldInventory)) {
            $newInventory = new Inventory($inventoryAdapter->getName(), $serialNumber, $inventoryAdapter->getValue());
            $this->inventoryRepository->insert($newInventory);
            return new Result(true, ResultStatus::CreationSuccess, $newInventory);
        } else {
            return new Result(false, ResultStatus::CreationFailedInventoryAlreadyExists, null);
        }
    }

}