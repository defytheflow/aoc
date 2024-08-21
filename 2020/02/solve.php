<?php

main();

function main()
{
    $input = parseInput(file_get_contents(__DIR__ . "/input.txt"));

    $resultOne = solveOne($input);
    echo $resultOne;
    assert($resultOne == 625);
}

/** @param ListEntry[] $input */
function solveOne(array $input): int
{
    return count(array_filter($input, function ($entry) {
        return $entry->isValid();
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
