<?php

namespace hdvianna\InventoryTrack\UseCases;

enum ResultStatus
{
    case CreationSuccess;
    case CreationFailedInventoryAlreadyExists;
}