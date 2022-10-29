<?php

namespace Heisenburger69\BurgerSpawners\entities\passive;

use pocketmine\player\Player;
use pocketmine\item\VanillaItems;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\data\bedrock\EnchantmentIds;
use pocketmine\data\bedrock\EnchantmentIdMap;
use Heisenburger69\BurgerSpawners\utils\EntityIds;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use Heisenburger69\BurgerSpawners\entities\SpawnerEntity;

class Cow extends SpawnerEntity
{
    public function getName(): string
    {
        return "Cow";
    }

    public function initEntity(CompoundTag $nbt): void
    {
        $this->setMaxHealth(10);
        parent::initEntity($nbt);
    }

    public function getDrops(): array
    {
        return $this->getLootFromFactors([
            VanillaItems::RAW_BEEF()->setCount(mt_rand(1, 3)),
            VanillaItems::LEATHER()->setCount(mt_rand(0, 2)),
        ]);
    }

    protected function getInitialSizeInfo(): EntitySizeInfo
    {
        return new EntitySizeInfo(1.3, 0.9);
    }

    public static function getNetworkTypeId(): string
    {
        return EntityIds::COW;
    }

    public function getXpDropAmount(): int
    {
        return mt_rand(1, 3);
    }
}
