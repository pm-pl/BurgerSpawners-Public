<?php

namespace Heisenburger69\BurgerSpawners\entities\hostile;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\entity\EntitySizeInfo;
use Heisenburger69\BurgerSpawners\entities\SpawnerEntity;
use Heisenburger69\BurgerSpawners\utils\EntityIds;

class Zoglin extends SpawnerEntity
{
    public function getName(): string
    {
        return "Zoglin";
    }

    public function initEntity(CompoundTag  $nbt): void
    {
        $this->setMaxHealth(40);
        parent::initEntity($nbt);
    }

    public function getInitialSizeInfo(): EntitySizeInfo
    {
        return new EntitySizeInfo(0.9, 0.9);
    }

    public static function getNetworkTypeId(): string
    {
        return EntityIds::ZOGLIN;
    }

    public function getXpDropAmount(): int
    {
        return mt_rand(1, 3);
    }
}
