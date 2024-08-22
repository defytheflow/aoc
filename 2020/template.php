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

function solveOne(string $input): int
{
    return -1;
}

function solveTwo(string $input): int
{
    return -1;
}

function parseInput(string $filename): string
{
    $input = trim(file_get_contents(__DIR__ . "/" . $filename));
    return $input;
}

main();
