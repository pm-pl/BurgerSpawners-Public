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

class Slime extends SpawnerEntity
{
    public function getName(): string
    {
        return "Slime";
    }

    public function initEntity(CompoundTag $nbt): void
    {
        $this->setMaxHealth(16);
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
        $drops = [VanillaItems::SLIMEBALL()->setCount(1 * $lootingL)];
        if (mt_rand(0, 199) < 5) {
            switch (mt_rand(0, 2)) {
                case 0:
                    $drops[] = VanillaItems::IRON_INGOT()->setCount(1 * $lootingL);
                    break;
                case 1:
                    $drops[] = VanillaItems::CARROT()->setCount(1 * $lootingL);
                    break;
                case 2:
                    $drops[] = VanillaItems::POTATO()->setCount(1 * $lootingL);
                    break;
            }
        }

        return $drops;
    }

    protected function getInitialSizeInfo(): EntitySizeInfo
    {
        return new EntitySizeInfo(2.04, 2.04);
    }

    public static function getNetworkTypeId(): string
    {
        return EntityIds::SLIME;
    }

    public function getXpDropAmount(): int
    {
        return mt_rand(1, 4);
    }
}
