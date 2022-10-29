<?php

namespace Heisenburger69\BurgerSpawners\entities\passive;

use pocketmine\entity\EntitySizeInfo;
use Heisenburger69\BurgerSpawners\entities\SpawnerEntity;
use Heisenburger69\BurgerSpawners\utils\EntityIds;

class Villager extends SpawnerEntity
{
    public function getName(): string
    {
        return "Villager";
    }

    protected function getInitialSizeInfo(): EntitySizeInfo
    {
        return new EntitySizeInfo(1.9, 0.6);
    }

    public static function getNetworkTypeId(): string
    {
        return EntityIds::VILLAGER;
    }
}
