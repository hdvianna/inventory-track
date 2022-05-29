<?php

namespace hdvianna\InventoryTrack\Adapters;

interface InventoryAdapter
{
    public function getName(): string;
    public function getSerialNumber() : string;
    public function getValue() :  float;
}