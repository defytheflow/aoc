<?php

main();

function main()
{
    $input = parseInput(file_get_contents(__DIR__ . "/input.txt"));

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
    return count(array_filter($input, function ($entry) {
        return $entry->isValid();
    }));
}

/** @param ListEntry[] $input */
function solveTwo(array $input): int
{
    return count(array_filter($input, function ($entry) {
        return $entry->isValidNew();
    }));
}

/** @return ListEntry[] */
function parseInput(string $input)
{
    return array_map(
        function ($line) {
            return ListEntry::fromInput($line);
        },
        explode(PHP_EOL, trim($input))
    );
}

class ListEntry
{
    public function __construct(
        private int $minCount,
        private int $maxCount,
        private string $letter,
        private string $password,
    )
    {
    }

    public function isValid(): bool
    {
        $letterCount = substr_count($this->password, $this->letter);
        return $this->minCount <= $letterCount && $letterCount <= $this->maxCount;
    }

    public function isValidNew(): bool
    {
        $firstIndex = $this->minCount - 1;
        $secondIndex = $this->maxCount - 1;

        $firstCondition = $this->password[$firstIndex] == $this->letter;
        $secondCondition = $this->password[$secondIndex] == $this->letter;

        return $firstCondition != $secondCondition;
    }

    public static function fromInput(string $line): ListEntry
    {
        [$policy, $letter, $password] = explode(" ", $line);
        [$minCount, $maxCount] = explode("-", $policy);

        $letter = rtrim($letter, ":");
        $minCount = (int)$minCount;
        $maxCount = (int)$maxCount;

        return new static($minCount, $maxCount, $letter, $password);
    }
}
