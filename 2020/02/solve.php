<?php

function main(): void
{
    $input = parseInput("input.txt");

    $resultOne = solveOne($input);
    echo $resultOne, PHP_EOL;
    assert($resultOne == 625);

    $resultTwo = solveTwo($input);
    echo $resultTwo, PHP_EOL;
    assert($resultTwo == 391);
}

/** @param ListEntry[] $input */
function solveOne(array $input): int
{
    $isValid = function (ListEntry $entry) {
        $letterCount = substr_count($entry->password, $entry->letter);
        return $entry->minCount <= $letterCount && $letterCount <= $entry->maxCount;
    };

    return count(array_filter($input, $isValid));
}

/** @param ListEntry[] $input */
function solveTwo(array $input): int
{
    $isValid = function (ListEntry $entry) {
        $i = $entry->minCount - 1;
        $j = $entry->maxCount - 1;
        return ($entry->password[$i] == $entry->letter) != ($entry->password[$j] == $entry->letter);
    };

    return count(array_filter($input, $isValid));
}

/** @return ListEntry[] */
function parseInput(string $filename): array
{
    $parseListEntry = function (string $line) {
        [$policy, $letter, $password] = explode(" ", $line);
        [$minCount, $maxCount] = array_map("intval", explode("-", $policy));
        return new ListEntry($minCount, $maxCount, rtrim($letter, ":"), $password);
    };

    $input = trim(file_get_contents(__DIR__ . "/" . $filename));
    return array_map($parseListEntry, explode(PHP_EOL, $input));
}

class ListEntry
{
    public function __construct(
        public int $minCount,
        public int $maxCount,
        public string $letter,
        public string $password,
    ) {
    }
}

main();
