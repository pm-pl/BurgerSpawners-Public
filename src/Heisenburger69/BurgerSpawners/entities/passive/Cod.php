<?php

namespace Heisenburger69\BurgerSpawners\entities\passive;

use pocketmine\item\VanillaItems;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\entity\EntitySizeInfo;
use Heisenburger69\BurgerSpawners\utils\EntityIds;
use Heisenburger69\BurgerSpawners\entities\SpawnerEntity;

class Cod extends SpawnerEntity
{
    public function getName(): string
    {
        return "Cod";
    }

    public function initEntity(CompoundTag $nbt): void
    {
        $this->setMaxHealth(6);
        parent::initEntity($nbt);
    }

    public function getDrops(): array
    {
        return $this->getLootFromFactors([
            VanillaItems::FEATHER()->setCount(mt_rand(0, 1)),
            VanillaItems::RAW_CHICKEN()->setCount(1)
        ]);
    }

    public function getInitialSizeInfo(): EntitySizeInfo
    {
        return new EntitySizeInfo(0.3, 0.6);
    }

    public static function getNetworkTypeId(): string
    {
        return EntityIds::COD;
    }
}
