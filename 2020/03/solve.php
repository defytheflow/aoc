<?php

declare(strict_types=1);
namespace Day03;

function main(): void
{
    $input = parseInput("input.txt");

    $resultOne = solveOne($input);
    echo $resultOne, PHP_EOL;
    assert($resultOne == 284);

    $resultTwo = solveTwo($input);
    echo $resultTwo, PHP_EOL;
    assert($resultTwo == 3_510_149_120);
}

/** @param string[] $input */
function solveOne(array $input): int
{
    return solve($input, new Point(x: 3, y: 1));
}

/** @param string[] $input */
function solveTwo(array $input): int
{
    return array_product(
        array_map(
            fn ($point) => solve($input, $point),
            [
                new Point(x: 1, y: 1),
                new Point(x: 3, y: 1),
                new Point(x: 5, y: 1),
                new Point(x: 7, y: 1),
                new Point(x: 1, y: 2),
            ]
        )
    );
}

/** @param string[] $input */
function solve(array $input, Point $slope): int
{
    $tree = "#";
    $width = strlen($input[0]);
    $height = count($input) - 1;

    $x = $y = 0;
    $trees = 0;

    while ($y < $height) {
        $x = ($x + $slope->x) % $width;
        $y += $slope->y;
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

class Point
{
    public function __construct(public int $x, public int $y)
    {
    }
}

main();
