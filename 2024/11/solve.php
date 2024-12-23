<?php

declare(strict_types=1);

namespace Day11;

require __DIR__ . "/LinkedList.php";

const NUMBER_OF_BLINKS = 25;

function main(): void
{
    $input = parseInput("input.txt");

    $resultOne = solveOne($input);
    echo $resultOne, PHP_EOL;
    assert($resultOne == 172_484);

    // $resultTwo = solveTwo($input);
    // echo $resultTwo, PHP_EOL;
    // assert($resultTwo == -1);
}

/**
 * @param LinkedList<int> $input
 */
function solveOne(LinkedList $input): int
{
    $list = &$input;

    for ($i = 0; $i < NUMBER_OF_BLINKS; $i++) {
        blink($list);
    }

    return count([...$list]);
}

/**
 * @param LinkedList<int> $list
 */
function blink(LinkedList $list): void
{
    $curr = $list->head();

    while ($curr !== null) {
        if ($curr->value == 0) {
            $curr->value = 1;
            $curr = $curr->next;
        } else if (hasEvenDigits($curr->value)) {
            ['first' => $first, 'second' => $second] = splitInTwo($curr->value);
            $curr->value = $first;
            $curr->next = new Node($second, $curr->next);
            $curr = $curr->next->next;
        } else {
            $curr->value *= 2024;
            $curr = $curr->next;
        }
    }
}

function hasEvenDigits(int $n): bool
{
    return strlen("$n") % 2 == 0;
}

/**
 * @return array{first: int, second: int}
 */
function splitInTwo(int $n): array
{
    $str = "$n";
    $mid = (int) (strlen($str) / 2);

    $first = substr($str, 0, $mid);
    $second = substr($str, $mid);

    return ['first' => (int) $first, 'second' => (int) $second];
}

/**
 * @param LinkedList<int> $input
 */
function solveTwo(LinkedList $input): int
{
    return -1;
}

/**
 * @return LinkedList<int>
 */
function parseInput(string $filename): LinkedList
{
    $input = file_get_contents(__DIR__ . "/" . $filename);

    if ($input === false) {
        throw new \RuntimeException("File \"$filename\" not found");
    }

    return LinkedList::fromArray(array_map("intval", explode(" ", trim($input))));
}

main();
