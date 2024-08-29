<?php

declare(strict_types=1);
namespace Day12;

function main(): void
{
    $input = parseInput("input.txt");

    $resultOne = solveOne($input);
    echo $resultOne, PHP_EOL;
    assert($resultOne == 1_010);
}

/** @param Action[] $input */
function solveOne(array $input): int
{
    $actions = &$input;
    $ship = new Ship();

    foreach ($actions as $action) {
        switch ($action->type) {
            case ActionType::FORWARD:
                $ship->forward($action->value);
                break;
            case ActionType::LEFT:
                $ship->turnClockWise(360 - $action->value);
                break;
            case ActionType::RIGHT:
                $ship->turnClockWise($action->value);
                break;
            case ActionType::NORTH:
                $ship->north($action->value);
                break;
            case ActionType::SOUTH:
                $ship->south($action->value);
                break;
            case ActionType::EAST:
                $ship->east($action->value);
                break;
            case ActionType::WEST:
                $ship->west($action->value);
                break;
        }
    }

    return abs($ship->x) + abs($ship->y);
}

/** @return Action[] */
function parseInput(string $filename): array
{
    $input = trim(file_get_contents(__DIR__ . "/" . $filename));
    return array_map("\Day12\Action::fromString", explode(PHP_EOL, $input));
}

enum ActionType: string
{
    case NORTH = "N";
    case SOUTH = "S";
    case EAST = "E";
    case WEST = "W";
    case LEFT = "L";
    case RIGHT = "R";
    case FORWARD = "F";
}

class Action
{
    public function __construct(public ActionType $type, public int $value) {}

    public static function fromString(string $line): static
    {
        $actionType = ActionType::from($line[0]);
        $actionValue = intval(substr($line, 1));
        return new static($actionType, $actionValue);
    }
}

enum Direction
{
    case NORTH;
    case SOUTH;
    case EAST;
    case WEST;
}

class Ship
{
    public int $x = 0;
    public int $y = 0;
    public Direction $dir = Direction::EAST;

    public function forward(int $units): void
    {
        switch ($this->dir) {
            case Direction::NORTH:
                $this->y -= $units;
                break;
            case Direction::SOUTH:
                $this->y += $units;
                break;
            case Direction::EAST:
                $this->x += $units;
                break;
            case Direction::WEST:
                $this->x -= $units;
                break;
        }
    }

    public function turnClockWise(int $degrees): void
    {
        switch ($degrees) {
            case 90:
                switch ($this->dir) {
                    case Direction::NORTH:
                        $this->dir = Direction::EAST;
                        break;
                    case Direction::EAST:
                        $this->dir = Direction::SOUTH;
                        break;
                    case Direction::SOUTH:
                        $this->dir = Direction::WEST;
                        break;
                    case Direction::WEST:
                        $this->dir = Direction::NORTH;
                        break;
                }
                break;
            case 180:
                switch ($this->dir) {
                    case Direction::NORTH:
                        $this->dir = Direction::SOUTH;
                        break;
                    case Direction::SOUTH:
                        $this->dir = Direction::NORTH;
                        break;
                    case Direction::EAST:
                        $this->dir = Direction::WEST;
                        break;
                    case Direction::WEST:
                        $this->dir = Direction::EAST;
                        break;
                }
                break;
            case 270:
                switch ($this->dir) {
                    case Direction::NORTH:
                        $this->dir = Direction::WEST;
                        break;
                    case Direction::EAST:
                        $this->dir = Direction::NORTH;
                        break;
                    case Direction::SOUTH:
                        $this->dir = Direction::EAST;
                        break;
                    case Direction::WEST:
                        $this->dir = Direction::SOUTH;
                        break;
                }
                break;
        }
    }

    public function north(int $units): void
    {
        $this->y -= $units;
    }

    public function south(int $units): void
    {
        $this->y += $units;
    }

    public function east(int $units): void
    {
        $this->x += $units;
    }

    public function west(int $units): void
    {
        $this->x -= $units;
    }
}

main();
