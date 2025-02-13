<?php

namespace Heisenburger69\BurgerSpawners\entities\hostile;

use pocketmine\player\Player;
use pocketmine\item\VanillaItems;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\data\bedrock\EnchantmentIds;
use pocketmine\data\bedrock\EnchantmentIdMap;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use Heisenburger69\BurgerSpawners\entities\SpawnerEntity;
use Heisenburger69\BurgerSpawners\utils\EntityIds;

class ElderGuardian extends SpawnerEntity
{
    public function getName(): string
    {
        return "Elder Guardian";
    }

    public function initEntity(CompoundTag $nbt): void
    {
        $this->setMaxHealth(80);
        parent::initEntity($nbt);
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
        return [
            VanillaItems::PRISMARINE_CRYSTALS()->setCount(mt_rand(0, 1 * $lootingL)),
            VanillaItems::PRISMARINE_SHARD()->setCount(mt_rand(0, 2 * $lootingL))
        ];
    }

    public function getInitialSizeInfo(): EntitySizeInfo
    {
        return new EntitySizeInfo(1.9975, 1.9975);
    }

    public static function getNetworkTypeId(): string
    {
        return EntityIds::ELDER_GUARDIAN;
    }

    public function getXpDropAmount(): int
    {
        return 10;
    }
}
