<?php

declare(strict_types=1);
namespace Day11;

function main(): void
{
    $input = parseInput("input.txt");

    $resultOne = solveOne($input);
    echo $resultOne, PHP_EOL;
    assert($resultOne == 2_283);

    $resultTwo = solveTwo($input);
    echo $resultTwo, PHP_EOL;
    assert($resultTwo == 2_054);
}

/** @param PositionType[][] $input */
function solveOne(array $input): int
{
    return solve($input, isOccupied: '\Day11\isImmediatelyAdjacent', limit: 4);
}

/** @param PositionType[][] $layout */
function isImmediatelyAdjacent(array &$layout, int $x, int $y, int $dx, int $dy): bool
{
    $ax = $x + $dx;
    $ay = $y + $dy;

    return (
        0 <= $ax && $ax < count($layout[$y]) &&
        0 <= $ay && $ay < count($layout) &&
        $layout[$ay][$ax] == PositionType::OCCUPIED_SEAT
    );
}

/** @param PositionType[][] $input */
function solveTwo(array $input): int
{
    return solve($input, isOccupied: '\Day11\isDistantAdjacent', limit: 5);
}

/** @param PositionType[][] $layout */
function isDistantAdjacent(array &$layout, int $x, int $y, int $dx, int $dy): bool
{
    $ax = $x + $dx;
    $ay = $y + $dy;

    while (0 <= $ax && $ax < count($layout[$y]) && 0 <= $ay && $ay < count($layout)) {
        $seat = $layout[$ay][$ax];

        if ($seat == PositionType::OCCUPIED_SEAT) {
            return true;
        }

        if ($seat == PositionType::EMPTY_SEAT) {
            return false;
        }

        $ax += $dx;
        $ay += $dy;
    }

    return false;
}

/**
 * @param PositionType[][] $input
 * @param callable(PositionType[][], int, int, int, int): bool $isOccupied
 */
function solve(array &$input, callable $isOccupied, int $limit): int
{
    $previousLayout = null;
    $currentLayout = &$input;

    while ($currentLayout != $previousLayout) {
        $previousLayout = $currentLayout;
        $currentLayout = createNextLayout($currentLayout, $isOccupied, $limit);
    }

    $count = 0;

    foreach ($currentLayout as $row) {
        foreach ($row as $seat) {
            if ($seat == PositionType::OCCUPIED_SEAT) {
                $count++;
            }
        }
    }

    return $count;
}

/**
 * @param PositionType[][] $layout
 * @param callable(PositionType[][], int, int, int, int): bool $isOccupied
 */
function createNextLayout(array &$layout, callable $isOccupied, int $limit): array
{
    $nextLayout = [];

    for ($y = 0; $y < count($layout); $y++) {
        $nextRow = [];

        for ($x = 0; $x < count($layout[$y]); $x++) {
            $adjacent = getAdjacentOccupiedSeats($layout, $x, $y, $isOccupied);
            $seat = $layout[$y][$x];

            if ($seat == PositionType::EMPTY_SEAT && $adjacent == 0) {
                $seat = PositionType::OCCUPIED_SEAT;
            } elseif ($seat == PositionType::OCCUPIED_SEAT && $adjacent >= $limit) {
                $seat = PositionType::EMPTY_SEAT;
            }

            array_push($nextRow, $seat);
        }

        array_push($nextLayout, $nextRow);
    }

    return $nextLayout;
}

/**
 * @param PositionType[][] $layout
 * @param callable(PositionType[][], int, int, int, int): bool $isOccupied
 */
function getAdjacentOccupiedSeats(array &$layout, int $x, int $y, callable $isOccupied): int
{
    $count = 0;
    $deltas = [[-1, 0], [1, 0], [0, -1], [0, 1], [-1, -1], [-1, 1], [1, -1], [1, 1]];

    foreach ($deltas as [$dx, $dy]) {
        if ($isOccupied($layout, $x, $y, $dx, $dy)) {
            $count++;
        }
    }

    return $count;
}

/** @return PositionType[][] */
function parseInput(string $filename): array
{
    $input = trim(file_get_contents(__DIR__ . "/" . $filename));

    return array_map(
        function ($line) {
            return array_map('\Day11\PositionType::from', str_split($line));
        },
        explode(PHP_EOL, $input)
    );
}

enum PositionType: string
{
    case FLOOR = ".";
    case EMPTY_SEAT = "L";
    case OCCUPIED_SEAT = "#";
}

main();
