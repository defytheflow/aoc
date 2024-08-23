<?php

function main(): void
{
    $input = parseInput("input.txt");

    $resultOne = solveOne($input);
    echo $resultOne, PHP_EOL;
    assert($resultOne == 6532);
}

/** @param string[] $input */
function solveOne(array $input): int
{
    return array_sum(
        array_map(
            fn ($group) => count(array_unique(str_split($group))),
            $input
        )
    );
}

/** @return string[] */
function parseInput(string $filename): array
{
    $input = trim(file_get_contents(__DIR__ . "/" . $filename));
    return array_map(
        fn ($group) => preg_replace("/\s/", "", $group),
        explode(str_repeat(PHP_EOL, 2), $input)
    );
}

main();
