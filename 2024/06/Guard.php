<?php

namespace Day06;

class Guard
{
    private const GUARD_CHAR = "^";
    private const OBSTACLE_CHAR = "#";

    private readonly Map $map;
    private Position $pos;
    private Direction $dir = Direction::NORTH;

    /**
     * @var Position[]
     */
    private array $visited = [];

    /**
     * @param string[][] $map
     */
    public function __construct(array $map)
    {
        $this->map = new Map($map);
        $this->initPosition();
    }

    public function move(): void
    {
        $nextPos = $this->pos->towards($this->dir);
        $maybeChar = $this->map->tryAt($nextPos);

        if ($maybeChar === null) {
            throw new OutOfMapException();
        }

        if ($maybeChar == self::OBSTACLE_CHAR) {
            throw new ObstacleException();
        }

        $this->visit($nextPos);
    }

    public function turnRight(): void
    {
        $this->dir = $this->dir->right();
    }

    public function visitedPositionsCount(): int
    {
        return count(array_unique(array_map("json_encode", $this->visited)));
    }

    private function initPosition(): void
    {
        $maybePos = $this->map->tryFind(self::GUARD_CHAR);

        if ($maybePos === null) {
            throw new \RuntimeException('Character char "' . self::GUARD_CHAR . '" not found on map');
        }

        $this->visit($maybePos);
    }

    private function visit(Position $pos): void
    {
        $this->pos = $pos;
        $this->visited[] = $this->pos;
    }
}

class Map
{
    /**
     * @param string[][] $map
     */
    public function __construct(private readonly array $map) {}

    public function tryAt(Position $pos): string|null
    {
        if (! $this->isValid($pos)) {
            return null;
        }
        return $this->map[$pos->y][$pos->x];
    }

    public function tryFind(string $char): Position|null
    {
        foreach ($this->map as $y => $row) {
            foreach ($row as $x => $col) {
                if ($col == $char) {
                    return new Position(x: $x, y: $y);
                }
            }
        }
        return null;
    }

    private function isValid(Position $pos): bool
    {
        return (
            0 <= $pos->x && $pos->x < count($this->map[0]) &&
            0 <= $pos->y && $pos->y < count($this->map)
        );
    }
}

class Position
{
    public function __construct(public readonly int $x, public readonly int $y) {}

    public function towards(Direction $dir): self
    {
        return match ($dir) {
            Direction::NORTH => new self(x: $this->x, y: $this->y - 1),
            Direction::EAST => new self(x: $this->x + 1, y: $this->y),
            Direction::SOUTH => new self(x: $this->x, y: $this->y + 1),
            Direction::WEST => new self(x: $this->x - 1, y: $this->y),
        };
    }
}

enum Direction
{
    case NORTH;
    case EAST;
    case WEST;
    case SOUTH;

    public function right(): self
    {
        return match ($this) {
            Direction::NORTH => Direction::EAST,
            Direction::EAST => Direction::SOUTH,
            Direction::SOUTH => Direction::WEST,
            Direction::WEST => Direction::NORTH,
        };
    }
}

class ObstacleException extends \Exception {}

class OutOfMapException extends \Exception {}
