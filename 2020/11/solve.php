<?php

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
    $previousLayout = null;
    $currentLayout = &$input;

    while ($currentLayout != $previousLayout) {
        $previousLayout = $currentLayout;
        $currentLayout = createNextLayout($currentLayout, 'getAdjacentOccupiedSeats', 4);
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

/** @param PositionType[][] $input */
function solveTwo(array $input): int
{
    $previousLayout = null;
    $currentLayout = &$input;

    while ($currentLayout != $previousLayout) {
        $previousLayout = $currentLayout;
        $currentLayout = createNextLayout($currentLayout, 'getAdjacentOccupiedSeatsTwo', 5);
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
function createNextLayout(array &$layout, callable $fn, int $limit): array
{
    $nextLayout = [];

    for ($y = 0; $y < count($layout); $y++) {
        $nextRow = [];

        for ($x = 0; $x < count($layout[$y]); $x++) {
            $adjacent = $fn($layout, $x, $y);
            $seat = $layout[$y][$x];

            if ($seat == PositionType::EMPTY_SEAT && $adjacent == 0) {
                $seat = PositionType::OCCUPIED_SEAT;
            } else if ($seat == PositionType::OCCUPIED_SEAT && $adjacent >= $limit) {
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

function getAdjacentOccupiedSeatsTwo(array &$layout, int $x, int $y): int
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

        // move in that direciton until we meet a seat or reach the end
        while (
            (0 <= $ax && $ax < $width) &&
            (0 <= $ay && $ay < $height)
        ) {
            $seat = $layout[$ay][$ax];
            if ($seat == PositionType::OCCUPIED_SEAT) {
                $count++;
                continue 2;
            } elseif ($seat == PositionType::EMPTY_SEAT) {
                continue 2;
            }
            $ax += $dx;
            $ay += $dy;
        }

    }

    return $count;
}

main();
