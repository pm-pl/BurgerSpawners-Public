<?php

namespace Heisenburger69\BurgerSpawners\entities\hostile;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\entity\EntitySizeInfo;
use Heisenburger69\BurgerSpawners\entities\SpawnerEntity;
use Heisenburger69\BurgerSpawners\utils\EntityIds;

class EnderDragon extends SpawnerEntity
{
    public function getName(): string
    {
        return "Ender Dragon";
    }

    public function initEntity(CompoundTag $nbt): void
    {
        $this->setMaxHealth(200);
        parent::initEntity($nbt);
    }

    public function getInitialSizeInfo(): EntitySizeInfo
    {
        return new EntitySizeInfo(8, 16);
    }

    public static function getNetworkTypeId(): string
    {
        return EntityIds::ENDER_DRAGON;
    }
}
