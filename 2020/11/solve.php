<?php

function main(): void
{
    $input = parseInput("input.txt");

    $resultOne = solveOne($input);
    echo $resultOne, PHP_EOL;
    assert($resultOne == 2_283);
}

/** @param PositionType[][] $input */
function solveOne(array $input): int
{
    $previousLayout = null;
    $currentLayout = &$input;

    while ($currentLayout != $previousLayout) {
        $previousLayout = $currentLayout;
        $currentLayout = createNextLayout($currentLayout);
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

/** @param PositionType[][] $layout */
function createNextLayout(array &$layout): array
{
    $nextLayout = [];

    for ($y = 0; $y < count($layout); $y++) {
        $nextRow = [];

        for ($x = 0; $x < count($layout[$y]); $x++) {
            $adjacent = getAdjacentOccupiedSeats($layout, $x, $y);
            $seat = $layout[$y][$x];

            if ($seat == PositionType::EMPTY_SEAT && $adjacent == 0) {
                $seat = PositionType::OCCUPIED_SEAT;
            } else if ($seat == PositionType::OCCUPIED_SEAT && $adjacent >= 4) {
                $seat = PositionType::EMPTY_SEAT;
            }

            array_push($nextRow, $seat);
        }

        array_push($nextLayout, $nextRow);
    }

    return $nextLayout;
}

function getAdjacentOccupiedSeats(array &$layout, int $x, int $y): int
{
    $count = 0;
    $width = count($layout[$y]);
    $height = count($layout);
    $deltas = [
        [-1, +0],
        [+1, +0],
        [+0, -1],
        [+0, +1],
        [-1, -1],
        [-1, +1],
        [+1, -1],
        [+1, +1],
    ];

    foreach ($deltas as [$dx, $dy]) {
        $ax = $x + $dx;
        $ay = $y + $dy;

        if (
            0 <= $ax && $ax < $width &&
            0 <= $ay && $ay < $height &&
            $layout[$ay][$ax] == PositionType::OCCUPIED_SEAT
        ) {
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
            return array_map('PositionType::from', str_split($line));
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

/** @param PositionType[][] $layout */
function printLayout(array $layout): void
{
    foreach ($layout as $row) {
        foreach ($row as $seat) {
            echo $seat->value;
        }
        echo "\n";
    }
}

main();
