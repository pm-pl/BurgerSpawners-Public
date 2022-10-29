<?php

namespace Heisenburger69\BurgerSpawners\entities;

use pocketmine\Server;
use pocketmine\item\Item;
use pocketmine\entity\Living;
use pocketmine\player\Player;
use pocketmine\entity\Location;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\crafting\FurnaceType;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\crafting\FurnaceRecipe;
use pocketmine\data\bedrock\EnchantmentIds;
use pocketmine\data\bedrock\EnchantmentIdMap;
use pocketmine\event\entity\EntityDeathEvent;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\event\entity\EntityDamageByEntityEvent;

class SpawnerEntity extends Living
{
    public CompoundTag $namedTag;

    public int $stack = 0;

    public function __construct(Location $location, ?CompoundTag $nbt = null)
    {
        parent::__construct($location, $this->namedTag = ($nbt ?? new CompoundTag()));
    }

    protected function onDeath(): void
    {
        $ev = new EntityDeathEvent($this, $this->getDrops(), $this->getXpDropAmount());
        $ev->call();
        foreach ($ev->getDrops() as $item) {
            $this->getWorld()->dropItem($this->location, $item);
        }

        //TODO: check death conditions (must have been damaged by player < 5 seconds from death)
        if ($this->lastDamageCause instanceof EntityDamageByEntityEvent) {
            $damager = $this->lastDamageCause->getDamager();
            if ($damager instanceof Player) {
                $damager->getXpManager()->addXp($ev->getXpDropAmount());
            }
        } else {
            $this->getWorld()->dropExperience($this->location, $ev->getXpDropAmount());
        }
        $this->startDeathAnimation();
    }

    public function getLootFromFactors(array $drops): array
    {
        $lootingL = 1;
        $cause = $this->lastDamageCause;
        if ($cause instanceof EntityDamageByEntityEvent) {
            $dmg = $cause->getDamager();
            if ($dmg instanceof Player) {
                $looting = $dmg->getInventory()->getItemInHand()->getEnchantment(EnchantmentIdMap::getInstance()->fromId(EnchantmentIds::LOOTING));
                if ($looting instanceof EnchantmentInstance) {
                    $lootingL = $looting->getLevel();
                }
            }
        }

        foreach ($drops as $drop) {
            if (!$drop instanceof Item) {
                continue;
            }

            // TODO: Is there a proper way?
            if ($this->isOnFire()) {
                $furnaceRecipe = Server::getInstance()->getCraftingManager()->getFurnaceRecipeManager(FurnaceType::FURNACE())->match($drop);
                if ($furnaceRecipe instanceof FurnaceRecipe) {
                    $drop = $furnaceRecipe->getResult();
                }
            }
            $drop->setCount($drop->getCount() * $lootingL);
        }
        return $drops;
    }

    public function getNamedTag(): CompoundTag
    {
        return $this->namedTag;
    }

    protected function getInitialSizeInfo(): EntitySizeInfo
    {
        return new EntitySizeInfo(1, 1);
    }

    public static function getNetworkTypeId(): string
    {
        return "burgerspawners:default";
    }

    public function getName(): string
    {
        return "BurgerMob";
    }

    public function canBeMovedByCurrents(): bool
    {
        return true;
    }
}
