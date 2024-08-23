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
    $shinyGoldColors = [];

    foreach ($bagMap as $color => $colorMap) {
        if (recOne($bagMap, $colorMap)) {
            array_push($shinyGoldColors, $color);
        }
    }

    return count(array_unique($shinyGoldColors));
}

/**
    @param array<str, array<str, int>> $bagMap
    @param array<str, int> $colorMap
*/
function recOne(&$bagMap, &$colorMap): bool
{
    foreach (array_keys($colorMap) as $innerColor) {
        if ($innerColor == "shiny gold") {
            return true;
        }
        if (recOne($bagMap, $bagMap[$innerColor])) {
            return true;
        }
    }
    return false;
}

/** @param string[] */
function solveTwo(array $input): int
{
    $bagMap = buildBagMap($input);
    return recTwo($bagMap, $bagMap["shiny gold"]);
}

/**
    @param array<str, array<str, int>> $bagMap
    @param array<str, int> $colorMap
*/
function recTwo(&$bagMap, &$colorMap): int
{
    $count = 0;

    foreach ($colorMap as $innerColor => $innerCount) {
        $count += $innerCount;
        $count += $innerCount * recTwo($bagMap, $bagMap[$innerColor]) ;
    }

    return $count;
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
        $words = str_word_count($line, 1, '1234567890');
        $color = $words[0] . " " . $words[1];

        if (str_ends_with($line, "no other bags.")) {
            $bagMap[$color] = [];
            continue;
        }


        /** @var array<str, int> */
        $innerBagMap = [];
        $words = array_slice($words, 4);

        foreach (array_chunk($words, 4) as [$count, $color1, $color2]) {
            $innerColor = $color1 . " " . $color2;
            $innerBagMap[$innerColor] = intval($count);
        }

        $bagMap[$color] = $innerBagMap;
    }

    return $bagMap;
}

main();
