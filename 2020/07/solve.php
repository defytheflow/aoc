<?php

function main(): void
{
    $input = parseInput("input.txt");

    $resultOne = solveOne($input);
    echo $resultOne, PHP_EOL;
    assert($resultOne == 124);

    $resultTwo = solveTwo($input);
    echo $resultTwo, PHP_EOL;
    assert($resultTwo == 34_862);
}

/** @param string[] */
function solveOne(array $input): int
{
    $bagMap = buildBagMap($input);

    /** @param array<str, int> $colorMap */
    $canContain = function (array $colorMap) use (&$bagMap, &$canContain): bool {
        foreach (array_keys($colorMap) as $color) {
            if ($color == "shiny gold") {
                return true;
            }
            if ($canContain($bagMap[$color])) {
                return true;
            }
        }
        return false;
    };

    return count(array_filter($bagMap, $canContain));
}

/** @param string[] */
function solveTwo(array $input): int
{
    $bagMap = buildBagMap($input);

    /** @param array<str, int> $colorMap */
    $countBags = function (array $colorMap) use (&$bagMap, &$countBags): int {
        $bagCount = 0;

        foreach ($colorMap as $color => $count) {
            $bagCount += $count;
            $bagCount += $count * $countBags($bagMap[$color]) ;
        }

        return $bagCount;
    };

    return $countBags($bagMap["shiny gold"]);
}

/** @return string[] */
function parseInput(string $filename): array
{
    $input = trim(file_get_contents(__DIR__ . "/" . $filename));
    return explode(PHP_EOL, $input);
}

/**
    @param string[] $input
    @return array<str, array<str, int>>
*/
function buildBagMap(array $input): array
{
    /** @var array<str, array<str, int>> */
    $bagMap = [];

    foreach ($input as $line) {
        $words = str_word_count($line, 1, "1234567890");
        $color = "$words[0] $words[1]";
        $bagMap[$color] = [];

        if (str_ends_with($line, "no other bags.")) {
            continue;
        }

        $colorMap = &$bagMap[$color];
        $otherWords = array_slice($words, 4);

        foreach (array_chunk($otherWords, 4) as [$count, $color1, $color2]) {
            $colorMap["$color1 $color2"] = intval($count);
        }
    }

    return $bagMap;
}

main();
