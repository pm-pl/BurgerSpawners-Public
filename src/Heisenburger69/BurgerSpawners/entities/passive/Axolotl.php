<?php

namespace Heisenburger69\BurgerSpawners\entities\passive;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\entity\EntitySizeInfo;
use Heisenburger69\BurgerSpawners\utils\EntityIds;
use Heisenburger69\BurgerSpawners\entities\SpawnerEntity;

class Axolotl extends SpawnerEntity
{
    public function getName(): string
    {
        return "Axolotl";
    }

    public function initEntity(CompoundTag $nbt): void
    {
        $this->setMaxHealth(14);
        parent::initEntity($nbt);
    }

    public function getInitialSizeInfo(): EntitySizeInfo
    {
        return new EntitySizeInfo(0.42, 0.75);
    }

    public static function getNetworkTypeId(): string
    {
        return EntityIds::AXOLOTL;
    }
}
