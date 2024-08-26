<?php

function main(): void
{
    $input = parseInput("input.txt");

    $resultOne = solveOne($input);
    echo $resultOne, PHP_EOL;
    assert($resultOne == 2_574);
}

/** @param int[] */
function solveOne(array $input): int
{
    $adapters = &$input;

    sort($adapters);
    array_push($adapters, $input[array_key_last($input)] + 3);

    $diffMap = [];
    $currentCharge = 0;

    for ($i = 0; $i < count($adapters); $i++) {
        $adapter = $adapters[$i];
        $chargeDiff = abs($adapter - $currentCharge);

        if ($chargeDiff <= 3) {
            $diffMap[$chargeDiff] = ($diffMap[$chargeDiff] ?? 0) + 1;
            $currentCharge += $chargeDiff;
        }
    }

    return $diffMap[1] * $diffMap[3];
}

/** @return int[] */
function parseInput(string $filename): array
{
    $input = trim(file_get_contents(__DIR__ . "/" . $filename));
    return array_map('intval', explode(PHP_EOL, $input));
}

main();
