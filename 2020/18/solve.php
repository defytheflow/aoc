<?php

declare(strict_types=1);

namespace Day18;

function main(): void
{
    $input = parseInput("input.txt");

    $resultOne = solveOne($input);
    echo $resultOne, PHP_EOL;
    assert($resultOne == 6_640_667_297_513);

    $resultTwo = solveTwo($input);
    echo $resultTwo, PHP_EOL;
    assert($resultTwo == 451_589_894_841_552);
}

/** @param string[] */
function solveOne(array $input): int
{
    return array_reduce($input, fn($total, $expr) => $total + calculate($expr), 0);
}

/** @param string[] */
function solveTwo(array $input): int
{
    return array_reduce($input, fn($total, $expr) => $total + calculate($expr, addFirst: true), 0);
}

function calculate(string $expr, bool $addFirst = false): int
{
    $openParen = strpos($expr, "(");

    if ($openParen !== false) {
        $closeParen = findCloseParen($expr, $openParen);
        $beforeParen = substr($expr, 0, $openParen);
        $insideParen = substr($expr, $openParen + 1, $closeParen - $openParen - 1);
        $afterParen = substr($expr, $closeParen + 1);

        return calculate(
            $beforeParen . calculate($insideParen, addFirst: $addFirst) . $afterParen,
            addFirst: $addFirst
        );
    }

    /** @var int[] */
    $stack = [];
    $tokens = tokenize($expr);

    if ($addFirst) {
        $addIndex = array_search("+", $tokens);

        if ($addIndex !== false) {
            $aIndex = $addIndex - 1;
            $bIndex = $addIndex + 1;
            array_splice($tokens, $aIndex, 3, (string) ($tokens[$aIndex] + $tokens[$bIndex]));
            return calculate(join($tokens), addFirst: $addFirst);
        }
    }

    for ($i = 0; $i < count($tokens); $i++) {
        $token = $tokens[$i];

        if (is_numeric($token)) {
            $value = intval($token);

            if (count($stack) > 0) {
                $prevValue = intval(array_pop($stack));
                $prevToken = $tokens[$i - 1];

                switch ($prevToken) {
                    case "+":
                        $value += $prevValue;
                        break;
                    case "*":
                        $value *= $prevValue;
                        break;
                }
            }

            array_push($stack, $value);
        }
    }

    return $stack[0];
}

function findCloseParen(string $expr, int $openIndex): int
{
    $stack = 1;
    $i = $openIndex;

    while ($stack > 0) {
        $i++;

        switch ($expr[$i]) {
            case "(":
                $stack++;
                break;
            case ")":
                $stack--;
                break;
        }
    }

    return $i;
}

/** @return string[] */
function tokenize(string $expr): array
{
    /** @var string [] */
    $tokens = [];

    for ($i = 0; $i < strlen($expr); $i++) {
        if ($expr[$i] == "+" || $expr[$i] == "*") {
            array_push($tokens, $expr[$i]);
        } elseif (is_numeric($expr[$i])) {
            $buffer = "";

            for (; $i < strlen($expr) && is_numeric($expr[$i]); $i++) {
                $buffer .= $expr[$i];
            }
            $i--;

            array_push($tokens, $buffer);
        }
    }

    return $tokens;
}

/** @return string[] */
function parseInput(string $filename): array
{
    $input = trim(file_get_contents(__DIR__ . "/" . $filename));
    return explode(PHP_EOL, $input);
}

main();
