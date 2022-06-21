<?php

namespace Heisenburger69\BurgerSpawners\entities\hostile;

use pocketmine\player\Player;
use pocketmine\item\VanillaItems;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\data\bedrock\EnchantmentIds;
use pocketmine\data\bedrock\EnchantmentIdMap;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use Heisenburger69\BurgerSpawners\entities\SpawnerEntity;
use Heisenburger69\BurgerSpawners\utils\EntityIds;

class Blaze extends SpawnerEntity
{
    public function getName(): string
    {
        return "Blaze";
    }

    public function getDrops(): array
    {
        $lootingL = 1;
        $cause = $this->lastDamageCause;
        if ($cause instanceof EntityDamageByEntityEvent) {
            $dmg = $cause->getDamager();
            if ($dmg instanceof Player) {


                $looting = $dmg->getInventory()->getItemInHand()->getEnchantment(EnchantmentIdMap::getInstance()->fromId(EnchantmentIds::LOOTING));
                if ($looting !== null) {
                    $lootingL = $looting->getLevel();
                } else {
                    $lootingL = 1;
                }
            }
        }
        return [VanillaItems::BLAZE_ROD()->setCount(mt_rand(0, 1 * $lootingL))];
    }

    public static function getNetworkTypeId(): string
    {
        return EntityIds::BLAZE;
    }

    public function getInitialSizeInfo(): EntitySizeInfo
    {
        return new EntitySizeInfo(1.8, 0.5);
    }

    public function getXpDropAmount(): int
    {
        return 10;
    }
}
