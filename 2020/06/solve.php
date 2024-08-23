<?php

function main(): void
{
    $input = parseInput("input.txt");

    $resultOne = solveOne($input);
    echo $resultOne, PHP_EOL;
    assert($resultOne == 6532);

    $resultTwo = solveTwo($input);
    echo $resultTwo, PHP_EOL;
    assert($resultTwo == 3427);
}

/** @param string[] $input */
function solveOne(array $input): int
{
    return array_sum(
        array_map(
            fn ($group) => count(array_unique(str_split(preg_replace("/\s/", "", $group)))),
            $input
        )
    );
}

/** @param string[] $input */
function solveTwo(array $input): int
{
    return array_sum(
        array_map(
            fn ($group) => count(array_intersect(...array_map('str_split', preg_split("/\s/", $group)))),
            $input
        )
    );
}

/** @return string[] */
function parseInput(string $filename): array
{
    $input = trim(file_get_contents(__DIR__ . "/" . $filename));
    return explode(str_repeat(PHP_EOL, 2), $input);
}

main();
