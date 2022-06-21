<?php

namespace Heisenburger69\BurgerSpawners\entities\neutral;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\entity\EntitySizeInfo;
use Heisenburger69\BurgerSpawners\entities\SpawnerEntity;
use Heisenburger69\BurgerSpawners\utils\EntityIds;

class Goat extends SpawnerEntity
{
    public function getName(): string
    {
        return "Goat";
    }

    public function initEntity(CompoundTag $nbt): void
    {
        $this->setMaxHealth(10);
        parent::initEntity($nbt);
    }

    public function getInitialSizeInfo(): EntitySizeInfo
    {
        return new EntitySizeInfo(1.3, 0.9);
    }

    public static function getNetworkTypeId(): string
    {
        return EntityIds::GOAT;
    }
}
