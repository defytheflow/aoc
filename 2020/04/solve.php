<?php

function main(): void
{
    $input = parseInput("input.txt");

    $resultOne = solveOne($input);
    echo $resultOne, PHP_EOL;
    assert($resultOne == 196);
}

/** @param string[][] $input */
function solveOne(array $input): int
{
    $requiredFields = ["byr", "iyr", "eyr", "hgt", "hcl", "ecl", "pid"];

    return count(
        array_filter(
            $input,
            function ($passport) use ($requiredFields) {
                return count(
                    array_filter(
                        $requiredFields,
                        function ($field) use ($passport) {
                            $exists = false;

                            foreach ($passport as $value) {
                                if (str_contains($value, $field)) {
                                    $exists = true;
                                    break;
                                }
                            }

                            return $exists;

                        }
                    )
                ) == count($requiredFields);
            }
        )
    );
}

/** @return string[][] */
function parseInput(string $filename): array
{
    $input = trim(file_get_contents(__DIR__ . "/" . $filename));

    return array_map(
        function ($line) {
            $array = preg_split("/\s/", $line);
            return $array;
        },
        explode(PHP_EOL . PHP_EOL, $input)
    );
}

main();

