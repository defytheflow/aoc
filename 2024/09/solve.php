<?php

declare(strict_types=1);

namespace Day09;

const FREE_SPACE = '.';

function main(): void
{
    $input = parseInput("input.txt");

    $resultOne = solveOne($input);
    echo $resultOne, PHP_EOL;
    assert($resultOne == 6_399_153_661_894);

    // $resultTwo = solveTwo($input);
    // echo $resultTwo, PHP_EOL;
    // assert($resultTwo == -1);
}

function solveOne(string $input): int
{
    $expanded = expand($input);
    $moved = move($expanded);
    return checksum($moved);
}

/**
 * @return string[]
 */
function expand(string $input): array
{
    /**
     * @var string[]
     */
    $expanded = [];

    for ($i = 0, $id = 0; $i < strlen($input); $i++) {
        $n = (int) $input[$i];

        if ($i % 2 == 0) {
            // n-block file
            for ($j = 0; $j < $n; $j++) {
                $expanded[] = "$id";
            }
            $id++;
        } else {
            // n-blocks free space
            for ($j = 0; $j < $n; $j++) {
                $expanded[] = FREE_SPACE;
            }
        }
    }

    return $expanded;
}

/**
 * @param string[] $input
 * @return string[]
 */
function move(array $input): array
{
    /**
     * @var string[]
     */
    $moved = &$input;

    $i = array_find($moved, fn($char) => $char == FREE_SPACE);
    $j = array_find_last($moved, fn($char) => $char != FREE_SPACE);

    while ($i !== false && $j !== false && $i < $j) {
        swap($moved, $i, $j);

        $i = array_find($moved, fn($char) => $char == FREE_SPACE, $i);
        $j = array_find_last($moved, fn($char) => $char != FREE_SPACE, $j);
    }

    return $moved;
}

/**
 * @param string[] $input
 */
function checksum(array $input): int
{
    $sum = 0;

    foreach ($input as $i => $char) {
        $sum += $i * (int) $char;
    }

    return $sum;
}

function array_find(array $array, callable $callback, ?int $start = null): int|false
{
    $start ??= 0;

    for ($i = $start; $i < count($array); $i++) {
        if ($callback($array[$i])) {
            return $i;
        }
    }

    return false;
}

function array_find_last(array $array, callable $callback, ?int $start = null): int|false
{
    $start ??= count($array) - 1;

    for ($i = $start; $i >= 0; $i--) {
        if ($callback($array[$i])) {
            return $i;
        }
    }

    return false;
}

function swap(array &$array, int $i, int $j): void
{
    $tmp = $array[$i];
    $array[$i] = $array[$j];
    $array[$j] = $tmp;
}

function solveTwo(string $input): int
{
    return -1;
}

function parseInput(string $filename): string
{
    $input = file_get_contents(__DIR__ . "/" . $filename);

    if ($input === false) {
        throw new \RuntimeException("File \"$filename\" not found");
    }

    return trim($input);
}

main();
