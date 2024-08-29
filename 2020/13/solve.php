<?php

declare(strict_types=1);

function main(): void
{
    $input = parseInput("input.txt");

    $resultOne = solveOne($input);
    echo $resultOne, PHP_EOL;
    assert($resultOne == 203);
}

function solveOne(Input $input): int
{
    $timestamp = $input->timestmap;
    $busIds = array_map("intval", array_filter($input->busIds, fn($id) => $id != "x"));

    $busTimestamps = array_map(
        function ($busId) use ($timestamp) {
            $busTimestamp = $busId;

            while ($busTimestamp < $timestamp) {
                $busTimestamp += $busId;
            }

            return $busTimestamp;
        },
        $busIds,
    );

    $minBusTimestamp = min($busTimestamps);
    $minBusId = $busIds[array_search($minBusTimestamp, $busTimestamps)];

    return ($minBusTimestamp - $timestamp) * $minBusId;
}

function parseInput(string $filename): Input
{
    $input = trim(file_get_contents(__DIR__ . "/" . $filename));
    [$timestamp, $busIds] = explode(PHP_EOL, $input);

    return new Input(intval($timestamp), explode(",", $busIds));
}

class Input
{
    /** @param string[] $busIds */
    public function __construct(public int $timestmap, public array $busIds) {}
}

main();
