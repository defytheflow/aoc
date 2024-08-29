<?php

declare(strict_types=1);

function main(): void
{
    $input = parseInput("input.txt");

    $resultOne = solveOne($input);
    echo $resultOne, PHP_EOL;
    assert($resultOne == 371);

    $resultTwo = solveTwo($input);
    echo $resultTwo, PHP_EOL;
    assert($resultTwo == 352);
}

/** @param int[] $input */
function solveOne(array $input): int
{
    return solve($input, 2020);
}

/** @param int[] $input */
function solveTwo(array $input): int
{
    return solve($input, 30_000_000);
}

/** @param int[] $input */
function solve(array $input, int $target): int
{
    /** @var array<int, int[]> */
    $spokenNumbers = [];
    foreach ($input as $i => $num) {
        $spokenNumbers[$num] = [$i + 1];
    }

    $turn = count($input);
    $lastSpokenNum = $input[count($input) - 1];

    while ($turn < $target) {
        $isFirstTimeSpoken = count($spokenNumbers[$lastSpokenNum]) == 1;

        if ($isFirstTimeSpoken) {
            $lastSpokenNum = 0;
        } else {
            [$i, $j] = $spokenNumbers[$lastSpokenNum];
            $lastSpokenNum = $j - $i;
        }

        $turn++;

        if (array_key_exists($lastSpokenNum, $spokenNumbers)) {
            array_push($spokenNumbers[$lastSpokenNum], $turn);

            if (count($spokenNumbers[$lastSpokenNum]) > 2) {
                array_shift($spokenNumbers[$lastSpokenNum]);
            }
        } else {
            $spokenNumbers[$lastSpokenNum] = [$turn];
        }
    }

    return $lastSpokenNum;
}

/** @return int[] */
function parseInput(string $filename): array
{
    $input = trim(file_get_contents(__DIR__ . "/" . $filename));
    return array_map("intval", explode(",", $input));
}

main();
