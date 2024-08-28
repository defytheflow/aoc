<?php

declare(strict_types=1);

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
    $requiredFieldNames = array_map(fn ($field) => $field->value, REQUIRED_FIELD_NAMES);

    /** @param Field[] $fields */
    $isValid = function ($fields) use (&$requiredFieldNames) {
        $fieldNames = array_map(fn ($field) => $field->name->value, $fields);
        return !array_diff($requiredFieldNames, $fieldNames);
    };

    return count(array_filter($input, $isValid));
}

/** @param Field[][] $input */
function solveTwo(array $input): int
{
    $requiredFieldNames = array_map(fn ($field) => $field->value, REQUIRED_FIELD_NAMES);

    /** @param Field[] $fields */
    $isValid = function ($fields) use (&$requiredFieldNames) {
        $validFieldNames = array_map(
            fn ($field) => $field->name->value,
            array_filter($fields, fn ($field) => $field->isValid())
        );
        return !array_diff($requiredFieldNames, $validFieldNames);
    };

    return count(array_filter($input, $isValid));
}

/** @return Field[][] */
function parseInput(string $filename): array
{
    $input = trim(file_get_contents(__DIR__ . "/" . $filename));

    return array_map(
        function ($chunk) {
            return array_map(
                function ($field) {
                    [$name, $value] = explode(":", $field);
                    $fieldName = FieldName::from($name);

                    $className = (match ($fieldName) {
                        FieldName::BirthYear => "BirthYear",
                        FieldName::IssueYear => "IssueYear",
                        FieldName::ExpirationYear => "ExpirationYear",
                        FieldName::Height => "Height",
                        FieldName::HairColor => "HairColor",
                        FieldName::EyeColor => "EyeColor",
                        FieldName::PassportId => "PassportId",
                        FieldName::CountryId => "CountryId",
                    });

                    return new $className($fieldName, $value);
                },
                preg_split("/\s/", $chunk)
            );
        },
        explode(str_repeat(PHP_EOL, 2), $input)
    );
}

enum FieldName: string
{
    case BirthYear = "byr";
    case IssueYear = "iyr";
    case ExpirationYear = "eyr";
    case Height = "hgt";
    case HairColor = "hcl";
    case EyeColor = "ecl";
    case PassportId = "pid";
    case CountryId = "cid";
}

/** @var FieldName[] */
const REQUIRED_FIELD_NAMES = [
    FieldName::BirthYear,
    FieldName::IssueYear,
    FieldName::ExpirationYear,
    FieldName::Height,
    FieldName::HairColor,
    FieldName::EyeColor,
    FieldName::PassportId,
];

abstract class Field
{
    public function __construct(public FieldName $name, public string $value)
    {
    }

    abstract public function isValid(): bool;
}

class BirthYear extends Field
{
    public function isValid(): bool
    {
        return isFourDigitNumberInRange($this->value, 1920, 2002);
    }
}

class IssueYear extends Field
{
    public function isValid(): bool
    {
        return isFourDigitNumberInRange($this->value, 2010, 2020);
    }
}

class ExpirationYear extends Field
{
    public function isValid(): bool
    {
        return isFourDigitNumberInRange($this->value, 2020, 2030);
    }
}

function isFourDigitNumberInRange(string $numStr, int $start, int $end): bool
{
    return preg_match("/^[0-9]{4}$/", $numStr) && $start <= $numStr && $numStr <= $end;
}

class Height extends Field
{
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

class HairColor extends Field
{
    public function isValid(): bool
    {
        return (bool) preg_match("/^#[0-9a-f]{6}$/", $this->value);
    }
}

class EyeColor extends Field
{
    private const VALID_COLORS = ["amb", "blu", "brn", "gry", "grn", "hzl", "oth"];

    public function isValid(): bool
    {
        return in_array($this->value, self::VALID_COLORS);
    }
}

class PassportId extends Field
{
    public function isValid(): bool
    {
        return (bool) preg_match("/^[0-9]{9}$/", $this->value);
    }
}

class CountryId extends Field
{
    public function isValid(): bool
    {
        return true;
    }
}

main();
