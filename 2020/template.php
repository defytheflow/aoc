<?php

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

/** @param string[] $input */
function solveOne(array $input): int
{
    return -1;
}

/** @param string[] $input */
function solveTwo(array $input): int
{
    return -1;
}

/** @return string[] */
function parseInput(string $filename): array
{
    $input = trim(file_get_contents(__DIR__ . "/" . $filename));
    return explode(PHP_EOL, $input);
}

main();
