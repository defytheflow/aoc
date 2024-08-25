<?php

function main(): void
{
    $input = parseInput("input.txt");

    $resultOne = solveOne($input);
    echo $resultOne, PHP_EOL;
    assert($resultOne == 1_018_944);
}

/** @param string[] */
function solveOne(array $input): int
{
    $targetSum = 2020;
    /** @var int[] */
    $seen = [];

    foreach ($input as $number) {
        $diff = $targetSum - $number;
        if (in_array($diff, $seen)) {
            return $number * $diff;
        }
        array_push($seen, $number);
    }

    return -1;
}

/** @return string[] */
function parseInput(string $filename): array
{
    $input = trim(file_get_contents(__DIR__ . "/" . $filename));
    return array_map('intval', explode(PHP_EOL, $input));
}

main();
