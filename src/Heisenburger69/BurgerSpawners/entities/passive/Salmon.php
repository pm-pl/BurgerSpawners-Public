<?php

namespace Heisenburger69\BurgerSpawners\entities\passive;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\entity\EntitySizeInfo;
use Heisenburger69\BurgerSpawners\entities\SpawnerEntity;
use Heisenburger69\BurgerSpawners\utils\EntityIds;

class Salmon extends SpawnerEntity
{
    public function getName(): string
    {
        return "Salmon";
    }

    public function initEntity(CompoundTag $nbt): void
    {
        $this->setMaxHealth(6);
        parent::initEntity($nbt);
    }

    public function getInitialSizeInfo(): EntitySizeInfo
    {
        return new EntitySizeInfo(0.75, 0.75);
    }

    public static function getNetworkTypeId(): string
    {
        return EntityIds::SALMON;
    }
}
