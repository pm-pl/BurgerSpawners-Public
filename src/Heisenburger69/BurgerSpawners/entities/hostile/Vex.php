<?php

namespace Heisenburger69\BurgerSpawners\entities\hostile;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\entity\EntitySizeInfo;
use Heisenburger69\BurgerSpawners\entities\SpawnerEntity;
use Heisenburger69\BurgerSpawners\utils\EntityIds;

class Vex extends SpawnerEntity
{
    public function getName(): string
    {
        return "Vex";
    }

    public function initEntity(CompoundTag $nbt): void
    {
        $this->setMaxHealth(14);
        parent::initEntity($nbt);
    }

    protected function getInitialSizeInfo(): EntitySizeInfo
    {
        return new EntitySizeInfo(0.8, 0.4);
    }

    public static function getNetworkTypeId(): string
    {
        return EntityIds::VEX;
    }

    public function getXpDropAmount(): int
    {
        return 5 + mt_rand(1, 3);
    }
}
