<?php

namespace Heisenburger69\BurgerSpawners\entities\passive;

use pocketmine\player\Player;
use pocketmine\item\VanillaItems;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\data\bedrock\EnchantmentIds;
use pocketmine\data\bedrock\EnchantmentIdMap;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use Heisenburger69\BurgerSpawners\entities\SpawnerEntity;
use Heisenburger69\BurgerSpawners\utils\EntityIds;

class Chicken extends SpawnerEntity
{
    public function getName(): string
    {
        return "Chicken";
    }

    public function initEntity(CompoundTag $nbt): void
    {
        $this->setMaxHealth(4);
        parent::initEntity($nbt);
    }

    public function getDrops(): array
    {
        return $this->getLootFromFactors([
            VanillaItems::FEATHER()->setCount(mt_rand(0, 1)),
            VanillaItems::RAW_CHICKEN()->setCount(1)
        ]);
    }

    protected function getInitialSizeInfo(): EntitySizeInfo
    {
        return new EntitySizeInfo(0, 0.6);
    }

    public static function getNetworkTypeId(): string
    {
        return EntityIds::CHICKEN;
    }

    public function getXpDropAmount(): int
    {
        return mt_rand(1, 3);
    }
}
