<?php

namespace hdvianna\InventoryTrack\Repositories;

use hdvianna\InventoryTrack\Entities\Inventory;

interface InventoryRepository
{
    public function insert(Inventory $inventory) : void;
    public function update(Inventory $inventory) : void;
    public function findBySerialNumber(string $serialNumber) : ?Inventory;
    /**
     * @param string $searchString
     * @return Inventory[]
     */
    public function search(string $searchString) : array;
}