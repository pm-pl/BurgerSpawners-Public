<?php

namespace Heisenburger69\BurgerSpawners\entities\passive;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\entity\EntitySizeInfo;
use Heisenburger69\BurgerSpawners\entities\SpawnerEntity;
use Heisenburger69\BurgerSpawners\utils\EntityIds;

class TropicalFish extends SpawnerEntity
{
    public function getName(): string
    {
        return "Tropical Fish";
    }

    public function initEntity(CompoundTag $nbt): void
    {
        $this->setMaxHealth(6);
        parent::initEntity($nbt);
    }

    public function getInitialSizeInfo(): EntitySizeInfo
    {
        return new EntitySizeInfo(0.52, 0.52);
    }

    public static function getNetworkTypeId(): string
    {
        return EntityIds::TROPICALFISH;
    }
}
