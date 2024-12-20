<?php

namespace Day07;

readonly class Equation
{
    /**
     * @param int[] $numbers
     */
    private function __construct(public int $testValue, private array $numbers) {}

    public static function from(string $input): self
    {
        [$testValueStr, $numbersStr]  = explode(": ", $input);

        $testValue = (int) $testValueStr;
        $numbers = array_map("intval", explode(" ", $numbersStr));

        return new self($testValue, $numbers);
    }

    public function isSolvable(): bool
    {
        $operatorPermutations = $this->permutations(count($this->numbers));

        foreach ($operatorPermutations as $operators) {
            $result = $this->numbers[0];

            for ($i = 1; $i < count($this->numbers); $i++) {
                $number = $this->numbers[$i];

                $result = match ($operators[$i - 1]) {
                    Operator::PLUS => $result + $number,
                    Operator::STAR => $result * $number,
                };
            }

            if ($result == $this->testValue) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return Operator[][]
     */
    private static function permutations(int $count): array
    {
        if ($count == 2) {
            return [
                [Operator::PLUS],
                [Operator::STAR],
            ];
        }

        $perms = [];

        foreach (self::permutations($count - 1) as $perm) {
            $perms[] = [...$perm, Operator::PLUS];
            $perms[] = [...$perm, Operator::STAR];
        }

        return $perms;
    }
}

enum Operator {
    case PLUS;
    case STAR;
}
