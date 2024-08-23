<?php

function main(): void
{
    $input = parseInput("input.txt");

    $resultOne = solveOne($input);
    echo $resultOne, PHP_EOL;
    assert($resultOne == 10_884_537);
}

/** @param int[] $input */
function solveOne(array $input): int
{
    $preamble = 25;

    for ($i = 0; $i < count($input); $i++) {
        $target = $input[$i + $preamble];

        if (!twoSum(array_slice($input, $i, $preamble), $target)) {
            return $target;
        }
    }

    return -1;
}

/** @param int[] $numbers */
function twoSum(array $numbers, int $target): bool
{
    for ($i = 0; $i < count($numbers); $i++) {
        for ($j = 0; $j < count($numbers); $j++) {
            if ($i == $j) {
                continue;
            }
            if ($numbers[$i] + $numbers[$j] == $target) {
                return true;
            }
        }
    }
    return false;
}

/** @return int[] */
function parseInput(string $filename): array
{
    $input = trim(file_get_contents(__DIR__ . "/" . $filename));
    return array_map('intval', explode(PHP_EOL, $input));
}

main();
