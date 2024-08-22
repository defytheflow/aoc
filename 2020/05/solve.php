<?php

function main(): void
{
    $input = parseInput("input.txt");

    $resultOne = solveOne($input);
    echo $resultOne, PHP_EOL;
    assert($resultOne == 928);

    $resultTwo = solveTwo($input);
    echo $resultTwo, PHP_EOL;
    assert($resultTwo == 610);
}

/** @param string[] $input */
function solveOne(array $input): int
{
    return max(array_map(fn ($line) => Seat::fromString($line)->getId(), $input));
}

/** @param string[] $input */
function solveTwo(array $input): int
{
    $seatsIds = array_map(fn ($line) => Seat::fromString($line)->getId(), $input);
    sort($seatsIds);

    foreach (array_chunk($seatsIds, 2) as [$first, $second]) {
        if ($second - $first > 1) {
            return $second - 1;
        }
    }

    return -1;
}

/** @return string[] */
function parseInput(string $filename): array
{
    $input = trim(file_get_contents(__DIR__ . "/" . $filename));
    return explode(PHP_EOL, $input);
}

class Seat
{
    public function __construct(public int $row, public int $column)
    {
    }

    public function __toString(): string
    {
        return "Seat(row = $this->row, column = $this->column, id = {$this->getId()})";
    }

    public function getId(): int
    {
        return $this->row * 8 + $this->column;
    }

    public static function fromString(string $line): Seat
    {
        $rowStart = 0;
        $rowEnd = 127;

        foreach (str_split(substr($line, 0, 7)) as $char) {
            $rowMid = intdiv($rowStart + $rowEnd, 2);
            switch ($char) {
                case "F":
                    $rowEnd = $rowMid;
                    break;
                case "B":
                    $rowStart = $rowMid + 1;
                    break;
            }
        }

        $colStart = 0;
        $colEnd = 7;

        foreach (str_split(substr($line, 7)) as $char) {
            $colMid = intdiv($colStart + $colEnd, 2);
            switch ($char) {
                case "L":
                    $colEnd = $colMid;
                    break;
                case "R":
                    $colStart = $colMid + 1;
                    break;
            }
        }

        return new static(row: $rowStart, column: $colStart);
    }
}

main();
