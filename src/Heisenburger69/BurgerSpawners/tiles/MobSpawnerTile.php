<?php

namespace Heisenburger69\BurgerSpawners\tiles;

use pocketmine\item\Item;
use pocketmine\world\World;
use pocketmine\entity\Human;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\entity\Location;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\block\BlockLegacyIds;
use pocketmine\block\tile\Spawnable;
use Heisenburger69\BurgerSpawners\utils\Forms;
use Heisenburger69\BurgerSpawners\utils\Utils;
use Heisenburger69\BurgerSpawners\utils\ConfigManager;
use Heisenburger69\BurgerSpawners\entities\SpawnerEntity;

class MobSpawnerTile extends Spawnable
{
    public const TILE_ID = "MobSpawner";
    public const TILE_BLOCK = BlockLegacyIds::MOB_SPAWNER;

    public const ENTITY_ID = "EntityId";
    public const ENTITY_IDENTIFIER = "EntityIdentifier";
    public const DISPLAY_ENTITY_SCALE = "DisplayEntityScale";

    public const SPAWN_COUNT = "SpawnCount";
    public const SPAWN_RANGE = "SpawnRange";

    public const MIN_SPAWN_DELAY = "MinSpawnDelay";
    public const MAX_SPAWN_DELAY = "MaxSpawnDelay";

    public int $entityId = 0;
    public string $entityIdentifier = "";
    public float $displayEntityScale = 1.0;

    public int $spawnCount = 1;
    public int $spawnRange = 4;

    public int $minDelay = 5;
    public int $delay = 5;

    public function __construct(World $level, Vector3 $pos)
    {
        $range = (int)ConfigManager::getValue("spawn-range");
        if ($range === 0) { //Patch for outdated configs without "spawn-range" entry
            $range = 8;
        }
        if (!isset($this->spawnRange)) {
            $this->spawnRange = $range;
        }

        $base = (int)ConfigManager::getValue("base-spawn-rate");
        $base = $base * 20;
        if (!isset($this->minDelay)) {
            $this->minDelay = $base;
        }
        if (!isset($this->delay)) {
            $this->delay = $base;
        }

        parent::__construct($level, $pos);
        if ($this->entityId > 0) {
            $this->onUpdate();
        }
    }

    public function copyDataFromItem(Item $item): void
    {
        $this->readSaveData($item->getNamedTag());

        parent::copyDataFromItem($item);
    }

    public function onUpdate(): bool
    {
        $this->position->getWorld()->scheduleDelayedBlockUpdate($this->position, 1);

        if (!$this->canUpdate()) {
            return true;
        }

        if ($this->delay-- < 0) {
            $success = 0;
            for ($i = 0; $i < 16; $i++) {
                if ($success > 0) {
                    $this->delay = $this->getBaseDelay();
                    return true;
                }
                $pos = $this->getPosition()->add(mt_rand() / mt_getrandmax() * $this->spawnRange, mt_rand(-1, 1), mt_rand() / mt_getrandmax() * $this->spawnRange);
                $target = $this->getPosition()->getWorld()->getBlock($pos);
                if ($target->getId() == BlockLegacyIds::AIR) {
                    $success++;
                    echo $this->entityIdentifier . "\n";
                    $entity = Utils::getEntityFromName($this->entityIdentifier, new Location($pos->getX(), $pos->getY(), $pos->getZ(), $this->getPosition()->getWorld(), 0, 0));
                    if ($entity instanceof SpawnerEntity) {
                        $entity->spawnToAll();
                    }
                }
            }
            if ($success > 0) {
                $this->delay = $this->getBaseDelay();
            }
        }
        return true;
    }

    public function canUpdate(): bool
    {
        if (!$this->getPosition()->getWorld()->isChunkLoaded($this->getPosition()->getX() >> 4, $this->getPosition()->getZ() >> 4)) {
            return false;
        }
        if ($this->spawnRange == '') {
            return false;
        }
        if (!$this->getPosition()->getWorld()->getTile($this->getPosition()) instanceof MobSpawnerTile) {
            return false;
        }
        if ($this->getPosition()->getWorld()->getNearestEntity($this->getPosition(), 25, Human::class) instanceof Player) {
            return true;
        }
        return false;
    }

    public function getName(): string
    {
        return Utils::getEntityNameFromID($this->entityIdentifier) . " Spawner";
    }

    public function getBaseDelay(): int
    {
        $baseDelay = 300 / $this->spawnCount;
        $this->setMinDelay($baseDelay);

        return $baseDelay;
    }

    public function setEntityId(int $entityId): void
    {
        $this->entityId = $entityId;

        $this->clearSpawnCompoundCache();
        $this->position->getWorld()->scheduleDelayedBlockUpdate($this->position, 1);
    }

    public function setEntityIdentifier(string $entityIdentifier): void
    {
        $this->entityIdentifier = $entityIdentifier;
    }

    public function setEntityScale(float $scale): void
    {
        $this->displayEntityScale = $scale;
    }

    public function setSpawnCount(int $value): void
    {
        $this->spawnCount = $value;
    }

    public function setSpawnRange(int $value): void
    {
        $this->spawnRange = $value;
    }

    public function setMinDelay(int $value): void
    {
        $this->minDelay = $value;
    }

    public function setDelay(int $value): void
    {
        $this->delay = $value;
    }

    public function writeSaveData(CompoundTag $nbt): void
    {
        $this->addAdditionalSpawnData($nbt);
    }

    public function addAdditionalSpawnData(CompoundTag $nbt): void
    {
        $nbt->setInt(self::ENTITY_ID, $this->entityId);
        $nbt->setString(self::ENTITY_IDENTIFIER, $this->entityIdentifier);
        $nbt->setFloat(self::DISPLAY_ENTITY_SCALE, 1.0);

        $nbt->setInt(self::SPAWN_COUNT, $this->spawnCount);
        $nbt->setInt(self::SPAWN_RANGE, $this->spawnRange);

        $nbt->setInt(self::MIN_SPAWN_DELAY, $this->minDelay);
        $nbt->setInt(self::MAX_SPAWN_DELAY, $this->delay);
    }

    public function readSaveData(CompoundTag $nbt): void
    {
        if (($entityId = $nbt->getTag(self::ENTITY_ID)) !== null) {
            $this->setEntityId($entityId->getValue());
        }
        if (($entityIdentifier = $nbt->getTag(self::ENTITY_IDENTIFIER)) !== null) {
            $this->setEntityIdentifier($entityIdentifier->getValue());
        }
        if (($displayEntityScale = $nbt->getTag(self::DISPLAY_ENTITY_SCALE)) !== null) {
            $this->setEntityScale($displayEntityScale->getValue());
        }

        if (($spawnCount = $nbt->getTag(self::SPAWN_COUNT)) !== null) {
            $this->setSpawnCount((int)$spawnCount->getValue());
        }
        if (($spawnRange = $nbt->getTag(self::SPAWN_RANGE)) !== null) {
            $this->setSpawnRange((int)$spawnRange->getValue());
        }

        if (($minDelay = $nbt->getTag(self::MIN_SPAWN_DELAY)) !== null) {
            $this->setMinDelay((int)$minDelay->getValue());
        }
        if (($delay = $nbt->getTag(self::MAX_SPAWN_DELAY)) !== null) {
            $this->setDelay((int)$delay->getValue());
        }
    }

    public function sendAddSpawnersForm(Player $player): void
    {
        Forms::sendAddSpawnerForm($player, $this);
    }

    public function sendRemoveSpawnersForm(Player $player): void
    {
        Forms::sendRemoveSpawnersForm($player, $this);
    }
}
