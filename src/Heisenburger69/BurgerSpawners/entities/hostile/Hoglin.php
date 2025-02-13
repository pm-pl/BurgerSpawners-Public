<?php

namespace Heisenburger69\BurgerSpawners\entities\hostile;

use pocketmine\player\Player;
use pocketmine\item\VanillaItems;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\data\bedrock\EnchantmentIds;
use pocketmine\data\bedrock\EnchantmentIdMap;
use Heisenburger69\BurgerSpawners\utils\EntityIds;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use Heisenburger69\BurgerSpawners\entities\SpawnerEntity;

class Hoglin extends SpawnerEntity
{
    public function getName(): string
    {
        return "Hoglin";
    }

    public function initEntity(CompoundTag  $nbt): void
    {
        $this->setMaxHealth(40);
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
            VanillaItems::RAW_PORKCHOP()->setCount(mt_rand(2, 3 + (1 * $lootingL))),
            VanillaItems::LEATHER()->setCount(mt_rand(0, 1 + (1 * $lootingL)))
        ];
    }

    public function getInitialSizeInfo(): EntitySizeInfo
    {
        return new EntitySizeInfo(0.9, 0.9);
    }

    public static function getNetworkTypeId(): string
    {
        return EntityIds::HOGLIN;
    }

    public function getXpDropAmount(): int
    {
        return 5;
    }
}
