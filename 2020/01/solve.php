<?php

declare(strict_types=1);
namespace Day01;

function main(): void
{
    $input = parseInput("input.txt");

    $resultOne = solveOne($input);
    echo $resultOne, PHP_EOL;
    assert($resultOne == 1_018_944);

    $resultTwo = solveTwo($input);
    echo $resultTwo, PHP_EOL;
    assert($resultTwo == 8_446_464);
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

/** @param string[] */
function solveTwo(array $input): int
{
    $targetSum = 2020;

    for ($i = 0; $i < count($input) - 2; $i++) {
        for ($j = $i + 1; $j < count($input) - 1; $j++) {
            for ($k = $j + 1; $k < count($input); $k++) {
                if ($input[$i] + $input[$j] + $input[$k] == $targetSum) {
                    return $input[$i] * $input[$j] * $input[$k];
                }
            }
        }
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
