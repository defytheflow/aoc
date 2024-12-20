<?php

declare(strict_types=1);

namespace Day06;

require_once __DIR__ . "/Guard.php";

function main(): void
{
    $input = parseInput("input.txt");

    $resultOne = solveOne($input);
    echo $resultOne, PHP_EOL;
    assert($resultOne == 4988);

    // $resultTwo = solveTwo($input);
    // echo $resultTwo, PHP_EOL;
    // assert($resultTwo == -1);
}

/**
 * @param string[][] $input
 */
function solveOne(array $input): int
{
    $map = &$input;
    $guard = new Guard($map);

    while (true) {
        try {
            $guard->move();
        } catch (ObstacleException) {
            $guard->turnRight();
        } catch (OutOfMapException) {
            break;
        }
    }

    return $guard->visitedPositionsCount();
}

/**
 * @param string[][] $input
 */
function solveTwo(array $input): int
{
    return -1;
}

/**
  * @return string[][]
  */
function parseInput(string $filename): array
{
    $input = file_get_contents(__DIR__ . "/" . $filename);

    if ($input === false) {
        throw new \RuntimeException("File \"$filename\" not found");
    }

    return array_map("str_split", explode(PHP_EOL, trim($input)));
}

main();
