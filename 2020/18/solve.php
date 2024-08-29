<?php

declare(strict_types=1);
namespace Day18;

function main(): void
{
    $input = parseInput("input.txt");

    $resultOne = solveOne($input);
    echo $resultOne, PHP_EOL;
    assert($resultOne == 6_640_667_297_513);
}

/** @param string[] */
function solveOne(array $input): int
{
    $total = 0;

    foreach ($input as $line) {
        $total += calculate($line);
    }

    return $total;
}

function calculate(string $expression): int
{
    $openParen = strpos($expression, "(");

    if (is_int($openParen)) {
        $closeParen = findCloseParen($expression, $openParen);
        $beforeParen = substr($expression, 0, $openParen);
        $insideParen = substr($expression, $openParen + 1, $closeParen - $openParen - 1);
        $afterParen = substr($expression, $closeParen + 1);
        return calculate($beforeParen . calculate($insideParen) . $afterParen);
    }

    $stack = [];

    for ($i = 0; $i < strlen($expression); $i++) {
        $char = $expression[$i];

        if (is_numeric($char)) {
            $prevToken = $expression[$i - 2];
            $buff = "";

            while (is_numeric($char)) {
                $buff .= $char;
                $i++;
                $char = $expression[$i];
            }
            $i--;

            $value = intval($buff);

            if (count($stack) > 0) {
                $prevValue = intval(array_pop($stack));

                if ($prevToken == "+") {
                    $value += $prevValue;
                } elseif ($prevToken == "*") {
                    $value *= $prevValue;
                }
            }

            array_push($stack, $value);
        }
    }

    return $stack[0];
}

function findCloseParen(string $expression, int $openIndex): int
{
    $stack = 1;
    $i = $openIndex;

    while ($stack > 0) {
        $i++;
        $char = $expression[$i];

        if ($char == "(") {
            $stack++;
        } elseif ($char == ")") {
            $stack--;
        }
    }

    return $i;
}

/** @return string[] */
function parseInput(string $filename): array
{
    $input = trim(file_get_contents(__DIR__ . "/" . $filename));
    return explode(PHP_EOL, $input);
}

main();
