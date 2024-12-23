<?php

declare(strict_types=1);

namespace Day__;

function main(): void
{
    $input = parseInput("input.txt");

    $resultOne = solveOne($input);
    echo $resultOne, PHP_EOL;
    assert($resultOne == 593);

    // $resultTwo = solveTwo($input);
    // echo $resultTwo, PHP_EOL;
    // assert($resultTwo == -1);
}

/**
 * @param int[][] $input
 */
function solveOne(array $input): int
{
    $map = &$input;
    $sum = 0;

    foreach ($map as $y => $row) {
        foreach ($row as $x => $value) {
            if ($value == 0) {
                $positions = positions($map, new Position(x: $x, y: $y));
                $sum += score($positions);
            }
        }
    }

    return $sum;
}

/**
 * @param int[][] $map
 * @return Position[]
 */
function positions(array &$map, Position $pos): array
{
    $value = $map[$pos->y][$pos->x];

    if ($value == 9) {
        return [$pos];
    }

    /**
     * @var Position[]
     */
    $positions = [];

    foreach (neighbors($map, $pos) as $nextPos) {
        if ($map[$nextPos->y][$nextPos->x] - $value == 1) {
            foreach (positions($map, $nextPos) as $finalPos) {
                $positions[] = $finalPos;
            }
        }
    }

    return $positions;
}

/**
 * @param int[][] $map
 * @return Position[]
 */
function neighbors(array &$map, Position $pos): array
{
    return array_filter(
        [$pos->up(), $pos->right(), $pos->down(), $pos->left()],
        fn($nPos) => isset($map[$nPos->y][$nPos->x])
    );
}

/**
 * @param Position[] $positions
 */
function score(array &$positions): int
{
    return count(array_unique(array_map("json_encode", $positions)));
}

/**
 * @param string[] $input
 */
function solveTwo(array $input): int
{
    return -1;
}

/**
 * @return int[][]
 */
function parseInput(string $filename): array
{
    $input = file_get_contents(__DIR__ . "/" . $filename);

    if ($input === false) {
        throw new \RuntimeException("File \"$filename\" not found");
    }

    return array_map(
        fn($line) => array_map("intval", str_split($line)),
        explode(PHP_EOL, trim($input)),
    );
}

main();

readonly class Position
{
    public function __construct(public int $x, public int $y) {}

    public function up(): self
    {
        return new self(x: $this->x, y: $this->y - 1);
    }

    public function right(): self
    {
        return new self(x: $this->x + 1, y: $this->y);
    }

    public function down(): self
    {
        return new self(x: $this->x, y: $this->y + 1);
    }

    public function left(): self
    {
        return new self(x: $this->x - 1, y: $this->y);
    }
}
