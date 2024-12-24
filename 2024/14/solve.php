<?php

declare(strict_types=1);

namespace Day14;

const WIDTH = 101;
const HEIGHT = 103;
const SECONDS = 100;

require_once __DIR__ . "/Robot.php";
require_once __DIR__ . "/debug.php";

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

    for ($i = 0; $i < SECONDS; $i++) {
        foreach ($robots as $robot) {
            $robot->move();
        }
    }

    return safety($robots);
}

/**
 * @param Robot[] $robots
 */
function safety(array &$robots): int
{
    $topLeft = 0;
    for ($y = 0; $y < floor(HEIGHT / 2); $y++) {
        for ($x = 0; $x < floor(WIDTH / 2); $x++) {
            foreach ($robots as $robot) {
                if ($robot->pos()->x == $x && $robot->pos()->y == $y) {
                    $topLeft++;
                }
            }
        }
    }

    $topRight = 0;
    for ($y = 0; $y < floor(HEIGHT / 2); $y++) {
        for ($x = ceil(WIDTH / 2); $x < WIDTH; $x++) {
            foreach ($robots as $robot) {
                if ($robot->pos()->x == $x && $robot->pos()->y == $y) {
                    $topRight++;
                }
            }
        }
    }

    $bottomLeft = 0;
    for ($y = ceil(HEIGHT / 2); $y < HEIGHT; $y++) {
        for ($x = 0; $x < floor(WIDTH / 2); $x++) {
            foreach ($robots as $robot) {
                if ($robot->pos()->x == $x && $robot->pos()->y == $y) {
                    $bottomLeft++;
                }
            }
        }
    }

    $bottomRight = 0;
    for ($y = ceil(HEIGHT / 2); $y < HEIGHT; $y++) {
        for ($x = ceil(WIDTH / 2); $x < WIDTH; $x++) {
            foreach ($robots as $robot) {
                if ($robot->pos()->x == $x && $robot->pos()->y == $y) {
                    $bottomRight++;
                }
            }
        }
    }

    return $topLeft * $topRight * $bottomLeft * $bottomRight;
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
