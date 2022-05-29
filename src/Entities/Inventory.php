<?php

namespace hdvianna\InventoryTrack\Entities;

/** @psalm-immutable */
class Inventory
{
    /**
     * @param string $name
     * @param string $serialNumber
     * @param float $value
     */
    public function __construct(
        public readonly string $name,
        public readonly string $serialNumber,
        public readonly float $value,
    ) { }
}