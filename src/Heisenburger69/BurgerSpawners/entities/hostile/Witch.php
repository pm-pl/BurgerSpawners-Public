<?php

namespace Heisenburger69\BurgerSpawners\entities\hostile;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\entity\EntitySizeInfo;
use Heisenburger69\BurgerSpawners\entities\SpawnerEntity;
use Heisenburger69\BurgerSpawners\utils\EntityIds;

class Witch extends SpawnerEntity
{
    public function getName(): string
    {
        return "Witch";
    }

    public function initEntity(CompoundTag $nbt): void
    {
        $this->setMaxHealth(26);
        parent::initEntity($nbt);
    }

    protected function getInitialSizeInfo(): EntitySizeInfo
    {
        return new EntitySizeInfo(1.95, 0.6);
    }

    public static function getNetworkTypeId(): string
    {
        return EntityIds::WITCH;
    }

    public function getXpDropAmount(): int
    {
        return 5 + mt_rand(1, 3);
    }
}
