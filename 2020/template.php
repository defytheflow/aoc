<?php

declare(strict_types=1);

namespace Day__;

function main(): void
{
    $input = parseInput("example.txt");

    $resultOne = solveOne($input);
    echo $resultOne, PHP_EOL;
    assert($resultOne == -1);

    $resultTwo = solveTwo($input);
    echo $resultTwo, PHP_EOL;
    assert($resultTwo == -1);
}

/**
 * @param string[] $input
 */
function solveOne(array $input): int
{
    return -1;
}

/**
 * @param string[] $input
 */
function solveTwo(array $input): int
{
    return -1;
}

/**
 * @return string[]
 */
function parseInput(string $filename): array
{
    $input = file_get_contents(__DIR__ . "/" . $filename);

    if ($input === false) {
        throw new \RuntimeException("File \"$filename\" not found");
    }

    return explode(PHP_EOL, trim($input));
}

main();
