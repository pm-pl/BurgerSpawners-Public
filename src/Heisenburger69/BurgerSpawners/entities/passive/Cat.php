<?php

namespace Heisenburger69\BurgerSpawners\entities\passive;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\entity\EntitySizeInfo;
use Heisenburger69\BurgerSpawners\entities\SpawnerEntity;
use Heisenburger69\BurgerSpawners\utils\EntityIds;

class Cat extends SpawnerEntity
{
    public function getName(): string
    {
        return "Cat";
    }

    public function initEntity(CompoundTag $nbt): void
    {
        $this->setMaxHealth(10);
        parent::initEntity($nbt);
    }

    public function getInitialSizeInfo(): EntitySizeInfo
    {
        return new EntitySizeInfo(0.56, 0.48);
    }

    public static function getNetworkTypeId(): string
    {
        return EntityIds::CAT;
    }
}
