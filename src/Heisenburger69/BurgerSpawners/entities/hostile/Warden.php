<?php

namespace Heisenburger69\BurgerSpawners\entities\hostile;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\entity\EntitySizeInfo;
use Heisenburger69\BurgerSpawners\entities\SpawnerEntity;
use Heisenburger69\BurgerSpawners\utils\EntityIds;

class Warden extends SpawnerEntity
{
    public function getName(): string
    {
        return "Warden";
    }

    public function initEntity(CompoundTag $nbt): void
    {
        $this->setMaxHealth(500);
        parent::initEntity($nbt);
    }

    public function getInitialSizeInfo(): EntitySizeInfo
    {
        return new EntitySizeInfo(2.9, 0.9);
    }

    public static function getNetworkTypeId(): string
    {
        return EntityIds::WARDEN;
    }
}
