<?php

namespace hdvianna\InventoryTrack\UseCases\Results\Statuses;

enum ManageInventoryResultStatus
{
    case CreationSuccess;
    case CreationFailedInventoryAlreadyExists;
}