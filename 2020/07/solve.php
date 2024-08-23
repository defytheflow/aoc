<?php

function main(): void
{
    $input = parseInput("input.txt");

    $resultOne = solveOne($input);
    echo $resultOne, PHP_EOL;
    assert($resultOne == 124);
}

/** @param string[] */
function solveOne(array $input): int
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

    $uniqueColors = [];

    foreach ($bagMap as $color => $colorMap) {
        if (rec($bagMap, $colorMap)) {
            array_push($uniqueColors, $color);
        }
    }

    return count(array_unique($uniqueColors));
}

function rec(&$bagMap, &$colorMap)
{
    foreach ($colorMap as $innerColor => $_) {
        if ($innerColor == "shiny gold") {
            return true;
        }
        $newColorMap = $bagMap[$innerColor];
        if (rec($bagMap, $newColorMap,)) {
            return true;
        }
    }
    return false;
}

/** @return string[] */
function parseInput(string $filename): array
{
    $input = trim(file_get_contents(__DIR__ . "/" . $filename));
    return explode(PHP_EOL, $input);
}

main();
