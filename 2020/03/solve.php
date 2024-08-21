<?php

function main(): void
{
    $input = parseInput("input.txt");

    $resultOne = solveOne($input);
    echo $resultOne, PHP_EOL;
    assert($resultOne == 284);
}

/** @param string[] $input */
function solveOne(array $input): int
{
    $tree = "#";
    $width = strlen($input[0]);
    $height = count($input) - 1;

    $x = $y = 0;
    $trees = 0;

    while ($y < $height) {
        $x = ($x + 3) % $width;
        $y++;
        if ($input[$y][$x] == $tree) {
            $trees++;
        }
    }

    return $trees;
}

/** @return string[] */
function parseInput(string $filename): array
{
    $input = trim(file_get_contents(__DIR__ . "/" . $filename));
    return explode(PHP_EOL, $input);
}

main();

