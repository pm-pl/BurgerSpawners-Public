<?php

declare(strict_types=1);

namespace Heisenburger69\BurgerSpawners\utils;

use DirectoryIterator;
use ReflectionException;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use ReflectionClassConstant;
use RecursiveIteratorIterator;
use pocketmine\entity\Location;
use RecursiveDirectoryIterator;
use pocketmine\item\ItemFactory;
use pocketmine\utils\TextFormat;
use pocketmine\item\VanillaItems;
use pocketmine\block\VanillaBlocks;
use pocketmine\nbt\tag\CompoundTag;
use Heisenburger69\BurgerSpawners\Main;
use Heisenburger69\BurgerSpawners\items\SpawnEgg;
use Heisenburger69\BurgerSpawners\utils\EntityIds;
use Heisenburger69\BurgerSpawners\tiles\MobSpawnerTile;
use Heisenburger69\BurgerSpawners\entities\SpawnerEntity;

class Utils
{
    public const ENTITY_IDS = [
        // HOSTILE
        EntityIds::BLAZE,
        EntityIds::CREEPER,
        EntityIds::DROWNED,
        EntityIds::ELDER_GUARDIAN,
        EntityIds::ENDER_DRAGON,
        EntityIds::ENDERMITE,
        EntityIds::EVOCATION_ILLAGER,
        EntityIds::GHAST,
        EntityIds::GUARDIAN,
        EntityIds::HOGLIN,
        EntityIds::HUSK,
        EntityIds::MAGMA_CUBE,
        EntityIds::PHANTOM,
        EntityIds::PIGLIN,
        EntityIds::PIGLIN_BRUTE,
        EntityIds::PILLAGER,
        EntityIds::RAVAGER,
        EntityIds::SHULKER,
        EntityIds::SILVERFISH,
        EntityIds::SKELETON,
        EntityIds::SLIME,
        EntityIds::STRAY,
        EntityIds::VEX,
        EntityIds::VINDICATOR,
        EntityIds::WARDEN,
        EntityIds::WITCH,
        EntityIds::WITHER,
        EntityIds::WITHER_SKELETON,
        EntityIds::ZOGLIN,
        EntityIds::ZOMBIE,
        EntityIds::ZOMBIE_VILLAGER,

        // NEUTRAL
        EntityIds::BEE,
        EntityIds::CAVE_SPIDER,
        EntityIds::DOLPHIN,
        EntityIds::ENDERMAN,
        EntityIds::GOAT,
        EntityIds::IRON_GOLEM,
        EntityIds::LLAMA,
        EntityIds::POLAR_BEAR,
        EntityIds::PUFFERFISH,
        EntityIds::SPIDER,
        EntityIds::WANDERING_TRADER,
        EntityIds::WOLF,
        EntityIds::ZOMBIFIED_PIGLIN,

        // PASSIVE
        EntityIds::ALLAY,
        EntityIds::AXOLOTL,
        EntityIds::BAT,
        EntityIds::CAT,
        EntityIds::CHICKEN,
        EntityIds::COD,
        EntityIds::COW,
        EntityIds::DONKEY,
        EntityIds::FOX,
        EntityIds::FROG,
        EntityIds::GLOW_SQUID,
        EntityIds::HORSE,
        EntityIds::MOOSHROOM,
        EntityIds::MULE,
        EntityIds::OCELOT,
        EntityIds::PANDA,
        EntityIds::PARROT,
        EntityIds::PIG,
        EntityIds::RABBIT,
        EntityIds::SALMON,
        EntityIds::SHEEP,
        EntityIds::SKELETON_HORSE,
        EntityIds::SNOW_GOLEM,
        EntityIds::SQUID,
        EntityIds::STRIDER,
        EntityIds::TADPOLE,
        EntityIds::TROPICALFISH,
        EntityIds::TURTLE,
        EntityIds::VILLAGER,
        EntityIds::ZOMBIE_HORSE,
    ];

    public const ENTITY_NAMES = [
        // HOSTILE
        "Blaze",
        "Creeper",
        "Drowned",
        "Elder Guardian",
        "Ender Dragon",
        "Endermite",
        "Evocation Illager",
        "Ghast",
        "Guardian",
        "Hoglin",
        "Husk",
        "Magma Cube",
        "Phantom",
        "Piglin",
        "Piglin Brute",
        "Pillager",
        "Ravager",
        "Shulker",
        "Silverfish",
        "Skeleton",
        "Slime",
        "Stray",
        "Vex",
        "Vindicator",
        "Warden",
        "Witch",
        "Wither",
        "Wither Skeleton",
        "Zoglin",
        "Zombie",
        "Zombie Villager",

        // NEUTRAL
        "Bee",
        "Cave Spider",
        "Dolphin",
        "Enderman",
        "Goat",
        "Iron Golem",
        "Llama",
        "Polar Bear",
        "Pufferfish",
        "Spider",
        "Wandering Trader",
        "Wolf",
        "Zombified Piglin",

        // PASSIVE
        "Allay",
        "Axolotl",
        "Bat",
        "Cat",
        "Chicken",
        "Cod",
        "Cow",
        "Donkey",
        "Fox",
        "Frog",
        "Glow Squid",
        "Horse",
        "Mooshroom",
        "Mule",
        "Ocelot",
        "Panda",
        "Parrot",
        "Pig",
        "Rabbit",
        "Salmon",
        "Sheep",
        "Skeleton Horse",
        "Snow Golem",
        "Squid",
        "Strider",
        "Tadpole",
        "Tropical Fish",
        "Turtle",
        "Villager",
        "Zombie Horse",
    ];

    public static function getNamesID(): array
    {
        $namesID = [];
        foreach (self::ENTITY_NAMES as $key => $name) {
            $namesID[self::ENTITY_IDS[$key]] = $name;
        }
        return $namesID;
    }

    public static function getEntityNameFromID(string $entityId): string
    {
        return self::getNamesID()[$entityId] ?? "Monster";
    }

    public static function getEntityIDFromName(string $entityName): ?string
    {
        /** @phpstan-ignore-next-line */
        return array_flip(self::getNamesID())[$entityName] ?? null;
    }

    public static function getEntityFromId(string $entityId, Location $location): ?SpawnerEntity
    {
        return self::getEntityFromName(self::getEntityNameFromID($entityId), $location);
    }

    public static function getEntityFromName(string $entityName, Location $location): ?SpawnerEntity
    {
        $nbt = new CompoundTag();

        /** @var DirectoryIterator $file */
        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator(Main::getInstance()->getFile() . "src/Heisenburger69/BurgerSpawners/entities/")) as $file) {
            if ($file->getExtension() === "php" && strtolower($file->getBasename(".php")) === strtolower(str_replace(["minecraft:", " "], ["", ""], $entityName))) {
                $classNamespace = str_replace([".php", Main::getInstance()->getFile() . "src/", "/"], ["", "", "\\"], $file->getRealPath());
                $class = new $classNamespace($location, $nbt);
                if ($class instanceof SpawnerEntity) {
                    return $class;
                }
            }
        }
        return null;
    }

    public static function getClassFromId(string $entityId): ?string
    {
        return self::getClassFromName(self::getEntityNameFromID($entityId));
    }

    public static function getClassFromName(string $entityName): ?string
    {
        /** @var DirectoryIterator $file */
        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator(Main::getInstance()->getFile() . "src/Heisenburger69/BurgerSpawners/entities/")) as $file) {
            if ($file->getExtension() === "php" && strtolower($file->getBasename(".php")) === strtolower(str_replace(["minecraft:", " "], ["", ""], $entityName))) {
                return str_replace([".php", Main::getInstance()->getFile() . "src/", "/"], ["", "", "\\"], $file->getRealPath());
            }
        }
        return null;
    }

    public static function getSpawnerFromName(string $entityName, int $amount): Item
    {
        try {
            $reflectionConstant = new ReflectionClassConstant(EntityLegacyIds::class, strtoupper($entityName));
            $entityLegacyId = $reflectionConstant->getValue();
        } catch (ReflectionException $ex) {
            // TODO: EXCEPTION HANDLER
            return VanillaItems::AIR();
        }
        $nbt = new CompoundTag();
        $nbt->setInt(MobSpawnerTile::ENTITY_ID, $entityLegacyId);
        $nbt->setString(MobSpawnerTile::ENTITY_IDENTIFIER, self::getEntityIDFromName(ucwords(strtolower($entityName))) ?? EntityIds::PIG);

        $spawner = VanillaBlocks::MONSTER_SPAWNER()->asItem();
        $spawner->setCount($amount);
        $spawner->setNamedTag($nbt);
        $spawner->setCustomName(TextFormat::RESET . $entityName . " Spawner");

        return $spawner;
    }

    public static function getSpawnEggFromName(string $entityName, int $amount): Item
    {
        try {
            $reflectionConstant = new ReflectionClassConstant(EntityLegacyIds::class, strtoupper($entityName));
            $entityLegacyId = $reflectionConstant->getValue();
        } catch (ReflectionException $ex) {
            // TODO: EXCEPTION HANDLER
            return VanillaItems::AIR();
        }

        // TODO: NOT ALL SPAWN EGGS FOLLOW THE LEGACY IDS! I NEED TO IMPLEMENT LOGIC!
        $egg = ItemFactory::getInstance()->get(ItemIds::SPAWN_EGG, $entityLegacyId, $amount);
        if ($egg instanceof SpawnEgg) {
            $egg->setEntityIdentifier(self::getEntityIDFromName($entityName) ?? EntityIds::PIG);
            $egg->setCustomName(TextFormat::RESET . $entityName . " Spawn Egg");
            return $egg;
        }
        return VanillaItems::AIR();
    }
}
