<?php

namespace Heisenburger69\BurgerSpawners\entities\hostile;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\entity\EntitySizeInfo;
use Heisenburger69\BurgerSpawners\entities\SpawnerEntity;
use Heisenburger69\BurgerSpawners\utils\EntityIds;

class Wither extends SpawnerEntity
{
    public function getName(): string
    {
        return "Wither";
    }

    public function initEntity(CompoundTag $nbt): void
    {
        $this->setMaxHealth(300);
        parent::initEntity($nbt);
    }

    public function getInitialSizeInfo(): EntitySizeInfo
    {
        return new EntitySizeInfo(3.0, 1.0);
    }

    public static function getNetworkTypeId(): string
    {
        return EntityIds::WITHER;
    }
}
