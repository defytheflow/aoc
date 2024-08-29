<?php

declare(strict_types=1);

function main(): void
{
    $input = parseInput("input.txt");

    $resultOne = solveOne($input);
    echo $resultOne, PHP_EOL;
    assert($resultOne == 371);
}

/** @param int[] $input */
function solveOne(array $input): int
{
    /** @var int[] */
    $spokenNumbers = $input;
    $turn = count($input);

    while ($turn <= 2020) {
        $lastSpokenNum = $spokenNumbers[array_key_last($spokenNumbers)];
        $isFirstTimeSpoken = array_count_values($spokenNumbers)[$lastSpokenNum] == 1;

        if ($isFirstTimeSpoken) {
            $spokenNumbers[] = 0;
        } else {
            [$i, $j] = findLastTwo($spokenNumbers, $lastSpokenNum);
            $spokenNumbers[] = $j - $i;
        }

        $turn++;
    }

    return $lastSpokenNum;
}

/**
 * @param int[] $numbers
 * @return int[]
 */
function findLastTwo(array &$numbers, int $needle): array
{
    /** @var int[] */
    $indices = [];

    foreach ($numbers as $i => $num) {
        if ($num == $needle) {
            $indices[] = $i;
        }
    }

    return array_slice($indices, -2);
}

/** @return int[] */
function parseInput(string $filename): array
{
    $input = trim(file_get_contents(__DIR__ . "/" . $filename));
    return array_map("intval", explode(",", $input));
}

main();
