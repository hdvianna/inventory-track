<?php

namespace hdvianna\InventoryTrack\Tests\Entities;

use hdvianna\InventoryTrack\Entities\Inventory;
use PHPUnit\Framework\TestCase;

class InventoryTest extends TestCase
{
    /**
     * @covers hdvianna\InventoryTrack\Entities\Inventory
     */
    public function testNewInventory() {
        $expectedName = "Inventory Name";
        $expectedSerialNumber = "99999-99";
        $expectedValue = 1;
        $inventory = new Inventory($expectedName, $expectedSerialNumber, $expectedValue);
        $this->assertEquals($expectedName, $inventory->name);
        $this->assertEquals($expectedSerialNumber, $inventory->serialNumber);
        $this->assertEquals($expectedValue, $inventory->value);
    }

}
