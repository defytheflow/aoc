<?php

declare(strict_types=1);

namespace Day14;

const WIDTH = 101;
const HEIGHT = 103;
const SECONDS = 100;

require_once __DIR__ . "/Robot.php";
require_once __DIR__ . "/Map.php";

// 6 - incorrect (i really meant 7)
// 7 - incorrect
// 53 - incorrect
// 5 - incorrect

function main(): void
{
    $input = parseInput("input.txt");

    $resultOne = solveOne($input);
    echo $resultOne, PHP_EOL;
    assert($resultOne == 230_172_768);

    // $resultTwo = solveTwo($input);
    // echo $resultTwo, PHP_EOL;
    // assert($resultTwo == -1);
}

/**
 * @param Robot[] $input
 */
function solveOne(array $input): int
{
    $robots = &$input;
    $map = Map::create($robots);

    for ($i = 0; $i < SECONDS; $i++) {
        foreach ($robots as $robot) {
            $map->move($robot);
        }
    }

    return $map->safety();
}

/**
 * @param Robot[] $input
 */
function solveTwo(array $input): int
{
    return -1;
}

/**
 * @return Robot[]
 */
function parseInput(string $filename): array
{
    $input = file_get_contents(__DIR__ . "/" . $filename);

    if ($input === false) {
        throw new \RuntimeException("File \"$filename\" not found");
    }

    return array_map("\Day14\Robot::fromString", explode(PHP_EOL, trim($input)));
}

main();
