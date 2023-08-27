<?php

declare(strict_types=1);

namespace Repair\command;

use Repair\item\RepairCoin;
use Repair\Repair;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\permission\DefaultPermissions;
use pocketmine\item\Durable;
use pocketmine\player\Player;
use pocketmine\world\sound\AnvilUseSound;

final class RepairCommand extends Command
{
    public function __construct()
    {
        parent::__construct('수리', '아이템을 수리 할 수 있습니다.', '/수리');
        $this->setPermission(DefaultPermissions::ROOT_USER);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$sender instanceof Player) {
            return;
        }

        $item = $sender->getInventory()->getItemInHand();
        $coin = new RepairCoin();

        if (!$item instanceof Durable) {
            $sender->sendMessage(Repair::Prefix . '도구가 아닌 아이템은 수리되지 않습니다.');
            return;
        }

        if (!$item->getDamage()) {
            $sender->sendMessage(Repair::Prefix . '아이템 내구도가 닳아있지 않습니다.');
            return;
        }

        $coin->setCount(1);
        if(!$sender->getInventory()->contains($coin)) {
            $sender->sendMessage(Repair::Prefix . '수리 코인이 부족합니다.');
            return;
        }

        if (mt_rand(1, 100) <= 1) {
            $sender->getInventory()->removeItem($item);
            $sender->sendMessage(Repair::Prefix . '1퍼센트의 확률로 아이템이 파괴되었습니다!');
        } else {
            $item->setDamage(0);
            $sender->getInventory()->setItemInHand($item);
            $sender->sendMessage(Repair::Prefix . '아이템 수리가 완료되었습니다!');
            $sender->getWorld()->addSound($sender->getPosition(), new AnvilUseSound(), [$sender]);
            $sender->getInventory()->removeItem($coin); // 수리 코인을 제거한다고 가정합니다.
        }
    }
}