<?php

declare(strict_types=1);

namespace Day08;

require_once __DIR__ . "/debug.php";

const EMPTY_CHAR = '.';

function main(): void
{
    $input = parseInput("input.txt");

    $resultOne = solveOne($input);
    echo $resultOne, PHP_EOL;
    assert($resultOne == 357);

    // $resultTwo = solveTwo($input);
    // echo $resultTwo, PHP_EOL;
    // assert($resultTwo == -1);
}

/**
 * @param Tile[][] $input
 */
function solveOne(array $input): int
{
    $map = &$input;
    $antinodes = [];

    foreach ($map as $y => $row) {
        foreach ($row as $x => $tile) {
            if ($tile->char != EMPTY_CHAR) {
                $point = new Point(x: $x, y: $y, char: $tile->char);
                $maybePoints = findAntennaInLine($map, $point);

                foreach ($maybePoints as $maybePoint) {
                    if ($maybePoint->y > $point->y) {
                        $diffY = $maybePoint->y - $point->y;
                        $diffX = $maybePoint->x - $point->x;
                        $maybeAntinodePoint = $map[$point->y - $diffY][$point->x - $diffX] ?? null;
                        if ($maybeAntinodePoint) {
                            $maybeAntinodePoint->isAntinode = true;
                            $antinodes[] = new Point($point->x - $diffX, $point->y - $diffY, $maybeAntinodePoint->char);
                        }
                    } else {
                        $diffY = $point->y - $maybePoint->y;
                        $diffX = $point->x - $maybePoint->x;
                        $maybeAntinodePoint = $map[$point->y + $diffY][$point->x + $diffX] ?? null;
                        if ($maybeAntinodePoint) {
                            $maybeAntinodePoint->isAntinode = true;
                            $antinodes[] = new Point($point->x + $diffX, $point->y + $diffY, $maybeAntinodePoint->char);
                        }
                    }
                }
            }
        }
    }

    return count(array_unique(array_map("json_encode", $antinodes)));
}

/**
 * @param Tile[][] $map
 * @return Point[]
 */
function findAntennaInLine(array &$map, Point $point): array
{
    $points = [];

    // search up left
    for ($y = $point->y - 1; $y >= 0; $y--) {
        for ($x = $point->x - 1; $x >= 0; $x--) {
            if ($map[$y][$x]->char == $point->char) {
                $points[] = new Point($x, $y, $point->char);
            }
        }
    }

    // search up right
    for ($y = $point->y - 1; $y >= 0; $y--) {
        for ($x = $point->x + 1; $x < count($map[0]); $x++) {
            if ($map[$y][$x]->char == $point->char) {
                $points[] = new Point($x, $y, $point->char);
            }
        }
    }

    // search down left
    for ($y = $point->y + 1; $y < count($map); $y++) {
        for ($x = $point->x - 1; $x >= 0; $x--) {
            if ($map[$y][$x]->char == $point->char) {
                $points[] = new Point($x, $y, $point->char);
            }
        }
    }

    // search down right
    for ($y = $point->y + 1; $y < count($map); $y++) {
        for ($x = $point->x + 1; $x < count($map[0]); $x++) {
            if ($map[$y][$x]->char == $point->char) {
                $points[] = new Point($x, $y, $point->char);
            }
        }
    }

    return $points;
}

/**
 * @param Tile[][] $input
 */
function solveTwo(array $input): int
{
    return -1;
}

/**
 * @return Tile[][]
 */
function parseInput(string $filename): array
{
    $input = file_get_contents(__DIR__ . "/" . $filename);

    if ($input === false) {
        throw new \RuntimeException("File \"$filename\" not found");
    }

    return array_map(
        fn ($line) => array_map(
            fn ($char) => new Tile($char),
            str_split($line)
        ),
        explode(PHP_EOL, trim($input)),
    );
}

class Tile
{
    public function __construct(public readonly string $char, public bool $isAntinode = false)
    {
    }
}

readonly class Point
{
    public function __construct(public int $x, public int $y, public string $char) {}

}

main();
