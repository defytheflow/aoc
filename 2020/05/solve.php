<?php

function main(): void
{
    $input = parseInput("input.txt");

    $resultOne = solveOne($input);
    echo $resultOne, PHP_EOL;
    assert($resultOne == 928);

}

/** @param string[] $input */
function solveOne(array $input): int
{
    return max(array_map('getSeatId', $input));
}

function getSeatId(string $line): int
{
    $rowStart = 0;
    $rowEnd = 127;

    foreach (str_split(substr($line, 0, 7)) as $char) {
        $rowMid = intdiv($rowStart + $rowEnd, 2);
        switch ($char) {
            case "F":
                $rowEnd = $rowMid;
                break;
            case "B":
                $rowStart = $rowMid + 1;
                break;
        }
    }

    $colStart = 0;
    $colEnd = 7;

    foreach (str_split(substr($line, 7)) as $char) {
        $colMid = intdiv($colStart + $colEnd, 2);
        switch ($char) {
            case "L":
                $colEnd = $colMid;
                break;
            case "R":
                $colStart = $colMid + 1;
                break;
        }
    }

    $seatId = $rowStart * 8 + $colStart;
    return $seatId;
}

/** @return string[] */
function parseInput(string $filename): array
{
    $input = trim(file_get_contents(__DIR__ . "/" . $filename));
    return explode(PHP_EOL, $input);
}

main();

