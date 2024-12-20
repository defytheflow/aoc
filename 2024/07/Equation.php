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

    /**
     * @param Operator[] $operators
     */
    public function isSolvable(array $operators): bool
    {
        $operatorPermutations = $this->permutations($operators, count($this->numbers));

        foreach ($operatorPermutations as $operators) {
            $result = $this->numbers[0];

            for ($i = 1; $i < count($this->numbers); $i++) {
                $number = $this->numbers[$i];

                $result = match ($operators[$i - 1]) {
                    Operator::PLUS => $result + $number,
                    Operator::STAR => $result * $number,
                    Operator::CONCAT => (int) ("$result" . "$number")
                };
            }

            if ($result == $this->testValue) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param Operator[] $operators
     * @return Operator[][]
     */
    private static function permutations(array $operators, int $count): array
    {
        if ($count == 2) {
            return array_map(fn($operator) => [$operator], $operators);
        }

        $perms = [];

        foreach (self::permutations($operators, $count - 1) as $perm) {
            foreach ($operators as $operator) {
                $perms[] = [...$perm, $operator];
            }
        }

        return $perms;
    }
}

enum Operator
{
    case PLUS;
    case STAR;
    case CONCAT;
}
