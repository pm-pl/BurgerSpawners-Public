<?php

namespace Heisenburger69\BurgerSpawners\entities\passive;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\entity\EntitySizeInfo;
use Heisenburger69\BurgerSpawners\entities\SpawnerEntity;
use Heisenburger69\BurgerSpawners\utils\EntityIds;

class Turtle extends SpawnerEntity
{
    public function getName(): string
    {
        return "Turtle";
    }

    public function initEntity(CompoundTag $nbt): void
    {
        $this->setMaxHealth(30);
        parent::initEntity($nbt);
    }

    public function getInitialSizeInfo(): EntitySizeInfo
    {
        return new EntitySizeInfo(0.4, 1.2);
    }

    public static function getNetworkTypeId(): string
    {
        return EntityIds::TURTLE;
    }
}
