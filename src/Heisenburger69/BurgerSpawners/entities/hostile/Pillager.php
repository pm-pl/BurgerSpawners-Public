<?php

namespace Heisenburger69\BurgerSpawners\entities\hostile;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\entity\EntitySizeInfo;
use Heisenburger69\BurgerSpawners\entities\SpawnerEntity;
use Heisenburger69\BurgerSpawners\utils\EntityIds;

class Pillager extends SpawnerEntity
{
    public function getName(): string
    {
        return "Pillager";
    }

    public function initEntity(CompoundTag $nbt): void
    {
        $this->setMaxHealth(24);
        parent::initEntity($nbt);
    }

    public function getInitialSizeInfo(): EntitySizeInfo
    {
        return new EntitySizeInfo(1.0, 0.6);
    }

    public static function getNetworkTypeId(): string
    {
        return EntityIds::PILLAGER;
    }

    public function getXpDropAmount(): int
    {
        return 5;
    }
}
