<?php

namespace Heisenburger69\BurgerSpawners\entities\neutral;

use pocketmine\player\Player;
use pocketmine\item\VanillaItems;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\data\bedrock\EnchantmentIds;
use pocketmine\data\bedrock\EnchantmentIdMap;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use Heisenburger69\BurgerSpawners\entities\SpawnerEntity;
use Heisenburger69\BurgerSpawners\utils\EntityIds;

class PolarBear extends SpawnerEntity
{
    public function getName(): string
    {
        return "Polar Bear";
    }

    public function initEntity(CompoundTag $nbt): void
    {
        $this->setMaxHealth(30);
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
            VanillaItems::RAW_SALMON()->setCount(mt_rand(0, 2 * $lootingL)),
            VanillaItems::RAW_FISH()->setCount(mt_rand(0, 2 * $lootingL))
        ];
    }

    protected function getInitialSizeInfo(): EntitySizeInfo
    {
        return new EntitySizeInfo(0.7, 0.7);
    }

    public static function getNetworkTypeId(): string
    {
        return EntityIds::POLAR_BEAR;
    }

    public function getXpDropAmount(): int
    {
        return mt_rand(1, 3);
    }
}
