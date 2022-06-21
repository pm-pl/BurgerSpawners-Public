<?php

namespace Heisenburger69\BurgerSpawners\entities\passive;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\entity\EntitySizeInfo;
use Heisenburger69\BurgerSpawners\entities\SpawnerEntity;
use Heisenburger69\BurgerSpawners\utils\EntityIds;

class Strider extends SpawnerEntity
{
    public function getName(): string
    {
        return "Strider";
    }

    public function initEntity(CompoundTag $nbt): void
    {
        parent::initEntity($nbt);
    }

    public function getInitialSizeInfo(): EntitySizeInfo
    {
        return new EntitySizeInfo(1.7, 0.9);
    }

    public static function getNetworkTypeId(): string
    {
        return EntityIds::STRIDER;
    }
}
