<?php

function main(): void
{
    $input = parseInput("input.txt");

    $resultOne = solveOne($input);
    echo $resultOne, PHP_EOL;
    assert($resultOne == 2014);

    $resultTwo = solveTwo($input);
    echo $resultTwo, PHP_EOL;
    assert($resultTwo == 2251);
}

/** @param string[] $input */
function solveOne(array $input): int
{
    $interpreter = new Interpreter();
    $interpreter->execute($input);
    return $interpreter->acc;
}

/** @param string[] $input */
function solveTwo(array $input): int
{
    $instructions = &$input;

    foreach ($instructions as $index => $instruction) {
        if (str_starts_with($instruction, "nop")) {
            $instructions[$index] = str_replace("nop", "jmp", $instruction);
        } elseif (str_starts_with($instruction, "jmp")) {
            $instructions[$index] = str_replace("jmp", "nop", $instruction);
        }

        $interpeter = new Interpreter();
        if ($interpeter->execute($instructions)) {
            return $interpeter->acc;
        }

        $instructions[$index] = $instruction;
    }

    return -1;
}

/** @returns string[] */
function parseInput(string $filename): array
{
    $input = trim(file_get_contents(__DIR__ . "/" . $filename));
    return explode(PHP_EOL, $input);
}

class Interpreter
{
    public int $acc = 0;

    /** @param string[] $instructions */
    public function execute(array $instructions): bool
    {
        $ip = 0;
        /** @var int[] */
        $ranInstructions = [];

        while ($ip < count($instructions)) {
            if (in_array($ip, $ranInstructions)) {
                return false;
            }

            array_push($ranInstructions, $ip);

            [$operation, $argument] = explode(" ", $instructions[$ip]);
            $argument = intval($argument);

            switch ($operation) {
                case "nop":
                    $ip++;
                    break;
                case "acc":
                    $this->acc += $argument;
                    $ip++;
                    break;
                case "jmp":
                    $ip += $argument;
                    break;
            }
        }

        return true;
    }
}

main();
