<?php

namespace Heisenburger69\BurgerSpawners\entities\neutral;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\entity\EntitySizeInfo;
use Heisenburger69\BurgerSpawners\entities\SpawnerEntity;
use Heisenburger69\BurgerSpawners\utils\EntityIds;

class Pufferfish extends SpawnerEntity
{
    public function getName(): string
    {
        return "Pufferfish";
    }

    public function initEntity(CompoundTag $nbt): void
    {
        $this->setMaxHealth(6);
        parent::initEntity($nbt);
    }

    public function getInitialSizeInfo(): EntitySizeInfo
    {
        // TODO: IMPLEMENT LOGIC HERE
        return new EntitySizeInfo(0.35, 0.35);
    }

    public static function getNetworkTypeId(): string
    {
        return EntityIds::PUFFERFISH;
    }
}
