<?php

declare(strict_types=1);

namespace Repair\item;

use pocketmine\item\Item;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemTypeIds;

class RepairCoin extends Item{
    public function __construct(){
        parent::__construct(new ItemIdentifier(ItemTypeIds::PAPER), 'RepairCoin');
    }
}