<?php

declare(strict_types=1);

namespace Repair;

use Repair\item\RepairCoin;
use Repair\command\RepairCommand;
use pocketmine\inventory\CreativeInventory;
use pocketmine\plugin\PluginBase;

final class Repair extends PluginBase
{
    public const Prefix = '§l§gRepair §r§f';

    protected function onEnable(): void
    {
        $item = new RepairCoin();
        $this->getServer()->getCommandMap()->register('Repair', new RepairCommand());
        CreativeInventory::getInstance()->add($item->setCustomName('§r§g§l▶ §f수리 코인')->setLore(['', '§r§g§l• §r§7/수리']));
    }
}