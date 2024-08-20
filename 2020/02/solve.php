<?php

main();

function main()
{
    $input = file_get_contents(__DIR__ . "/input.txt");
    $resultOne = solveOne($input);
    print $resultOne . "\n";
}

function solveOne(string $input): int
{
    $lines = parseInput($input);

    return count(array_filter($lines, function ($entry) {
        return $entry->isValid();
    }));
}

function parseInput(string $input)
{
    return array_map(
        function ($line) {
            return new ListEntry($line);
        },
        explode(PHP_EOL, trim($input))
    );
}

class ListEntry
{
    private int $minCount;
    private int $maxCount;
    private string $letter;
    private string $password;

    public function __construct(string $line)
    {
        [$policy, $letter, $password] = explode(" ", $line);
        [$minCount, $maxCount] = explode("-", $policy);

        $this->letter = rtrim($letter, ":");
        $this->password = $password;
        $this->minCount = (int)$minCount;
        $this->maxCount = (int)$maxCount;
    }

    public function isValid(): bool
    {
        $letterCount = substr_count($this->password, $this->letter);
        return $this->minCount <= $letterCount && $letterCount <= $this->maxCount;
    }
}
