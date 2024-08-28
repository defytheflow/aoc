<?php

declare(strict_types=1);

function main(): void
{
    $input = parseInput("input.txt");

    $resultOne = solveOne($input);
    echo $resultOne, PHP_EOL;
    assert($resultOne == 10_884_537);

    $resultTwo = solveTwo($input);
    echo $resultTwo, PHP_EOL;
    assert($resultTwo == 1_261_309);
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

/** @param int[] $input */
function solveTwo(array $input): int
{
    $target = solveOne($input);

    for ($i = 0; $i < count($input); $i++) {
        $set = [$input[$i]];

        for ($j = $i + 1; $j < count($input); $j++) {
            $sum = array_sum($set);

            if ($sum == $target) {
                return min($set) + max($set);
            }

            if ($sum > $target) {
                continue 2;
            }

            array_push($set, $input[$j]);
        }

    }

    return -1;
}

/** @return int[] */
function parseInput(string $filename): array
{
    $input = trim(file_get_contents(__DIR__ . "/" . $filename));
    return array_map('intval', explode(PHP_EOL, $input));
}

/** @param int[] $numbers */
function twoSum(array $numbers, int $target): bool
{
    /** @var array<int, bool> */
    $map = [];

    for ($i = 0; $i < count($numbers); $i++) {
        $n = $numbers[$i];

        if (array_key_exists($n, $map)) {
            return true;
        } else {
            $map[$target - $n] = true;
        }
    }

    return false;
}

main();
