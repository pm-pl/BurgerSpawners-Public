<?php

namespace Heisenburger69\BurgerSpawners\entities\passive;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\entity\EntitySizeInfo;
use Heisenburger69\BurgerSpawners\entities\SpawnerEntity;
use Heisenburger69\BurgerSpawners\utils\EntityIds;

class Ocelot extends SpawnerEntity
{
    public function getName(): string
    {
        return "Ocelot";
    }

    public function initEntity(CompoundTag $nbt): void
    {
        $this->setMaxHealth(10);
        parent::initEntity($nbt);
    }

    protected function getInitialSizeInfo(): EntitySizeInfo
    {
        return new EntitySizeInfo(0.7, 0.6);
    }

    public static function getNetworkTypeId(): string
    {
        return EntityIds::OCELOT;
    }

    public function getXpDropAmount(): int
    {
        return mt_rand(1, 3);
    }
}
