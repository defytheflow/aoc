<?php

function main(): void
{
    $input = parseInput("input.txt");

    $resultOne = solveOne($input);
    echo $resultOne, PHP_EOL;
    assert($resultOne == 196);

    $resultTwo = solveTwo($input);
    echo $resultTwo, PHP_EOL;
    assert($resultTwo == 114);
}

/** @param Field[][] $input */
function solveOne(array $input): int
{
    return count(
        array_filter(
            $input,
            'hasRequiredFields',
        )
    );
}

/** @param Field[][] $input */
function solveTwo(array $input): int
{
    return count(
        array_filter(
            $input,
            function ($passport) {
                return (
                    hasRequiredFields($passport) &&
                    count(array_filter($passport, fn ($field) => $field->isValid())) == count($passport)
                );
            }
        )
    );
}

function hasRequiredFields(array $passport): bool
{
    $requiredFields = ["byr", "iyr", "eyr", "hgt", "hcl", "ecl", "pid"];
    return count(
        array_filter(
            $requiredFields,
            function ($field) use ($passport) {
                $exists = false;

                foreach ($passport as $value) {
                    if (str_contains($value->name, $field)) {
                        $exists = true;
                        break;
                    }
                }

                return $exists;

            }
        )
    ) == count($requiredFields);
}

/** @return Field[][] */
function parseInput(string $filename): array
{
    $input = trim(file_get_contents(__DIR__ . "/" . $filename));

    return array_map(
        function ($line) {
            $array = preg_split("/\s/", $line);

            return array_map(
                function ($field) {
                    [$name, $value] = explode(":", $field);

                    $x = (match ($name) {
                        "byr" => "BirthYear",
                        "iyr" => "IssueYear",
                        "eyr" => "ExpirationYear",
                        "hgt" => "Height",
                        "hcl" => "HairColor",
                        "ecl" => "EyeColor",
                        "pid" => "PassportId",
                        "cid" => "CountryId",
                    });

                    return new $x($name, $value);
                },
                $array
            );
        },
        explode(PHP_EOL . PHP_EOL, $input)
    );
}

abstract class Field {
    public function __construct(public string $name, public string $value) {}
    abstract public function isValid(): bool;
}

class BirthYear extends Field {
    public function isValid(): bool
    {
        return isFourDigitNumberInRange($this->value, 1920, 2002);
    }
}

class IssueYear extends Field {
    public function isValid(): bool
    {
        return isFourDigitNumberInRange($this->value, 2010, 2020);
    }
}

class ExpirationYear extends Field {
    public function isValid(): bool
    {
        return isFourDigitNumberInRange($this->value, 2020, 2030);
    }
}

class Height extends Field {
    public function isValid(): bool
    {
        if (!preg_match_all("/^([0-9]+)(cm|in)$/", $this->value, $match)) {
            return false;
        }

        $number = $match[1][0];
        $scale = $match[2][0];

        return match ($scale) {
            "cm" => 150 <= $number && $number <= 193,
            "in" => 59 <= $number && $number <= 76,
        };
    }
}

class HairColor extends Field {
    public function isValid(): bool
    {
        return preg_match("/^#[0-9a-f]{6}$/", $this->value);
    }
}

class EyeColor extends Field {
    public function isValid(): bool
    {
        $validColors = ["amb", "blu", "brn", "gry", "grn", "hzl", "oth"];
        return in_array($this->value, $validColors);
    }
}

class PassportId extends Field {
    public function isValid(): bool
    {
        return preg_match("/^[0-9]{9}$/", $this->value);
    }
}

class CountryId extends Field {
    public function isValid(): bool
    {
        return true;
    }
}

function isFourDigitNumberInRange(string $numStr, int $start, int $end): bool
{
    return preg_match("/^[0-9]{4}$/", $numStr) && $start <= $numStr && $numStr <= $end;
}

main();
