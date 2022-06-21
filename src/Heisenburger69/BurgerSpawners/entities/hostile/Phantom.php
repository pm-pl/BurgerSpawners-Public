<?php

namespace Heisenburger69\BurgerSpawners\entities\hostile;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\entity\EntitySizeInfo;
use Heisenburger69\BurgerSpawners\entities\SpawnerEntity;
use Heisenburger69\BurgerSpawners\utils\EntityIds;

class Phantom extends SpawnerEntity
{
    public function getName(): string
    {
        return "Phantom";
    }

    public function initEntity(CompoundTag $nbt): void
    {
        parent::initEntity($nbt);
    }

    public function getInitialSizeInfo(): EntitySizeInfo
    {
        return new EntitySizeInfo(0.5, 0.9);
    }

    public static function getNetworkTypeId(): string
    {
        return EntityIds::PHANTOM;
    }
}
