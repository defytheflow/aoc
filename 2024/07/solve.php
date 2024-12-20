<?php

declare(strict_types=1);

namespace Day07;

require __DIR__ . '/Equation.php';

function main(): void
{
    $input = parseInput("input.txt");

    $resultOne = solveOne($input);
    echo $resultOne, PHP_EOL;
    assert($resultOne == 2_299_996_598_890);

    $resultTwo = solveTwo($input);
    echo $resultTwo, PHP_EOL;
    assert($resultTwo == 362_646_859_298_554);
}

/**
 * @param Equation[] $input
 */
function solveOne(array $input): int
{
    return solve($input, [Operator::PLUS, Operator::STAR]);
}

/**
 * @param Equation[] $input
 */
function solveTwo(array $input): int
{
    return solve($input, [Operator::PLUS, Operator::STAR, Operator::CONCAT]);
}

/**
 * @param Equation[] $input
 * @param Operator[] $operators
 */
function solve(array $input, array $operators): int
{
    $equations = &$input;

    return array_sum(
        array_map(
            fn($equation) => $equation->testValue,
            array_filter(
                $equations,
                fn($equation) => $equation->isSolvable($operators),
            )
        )
    );
}

/**
 * @return Equation[]
 */
function parseInput(string $filename): array
{
    $input = file_get_contents(__DIR__ . "/" . $filename);

    if ($input === false) {
        throw new \RuntimeException("File \"$filename\" not found");
    }

    return array_map('Day07\Equation::from', explode(PHP_EOL, trim($input)));
}

main();
