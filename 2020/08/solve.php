<?php

function main(): void
{
    $input = parseInput("input.txt");

    $resultOne = solveOne($input);
    echo $resultOne, PHP_EOL;
    assert($resultOne == 2014);
}

function solveOne(string $input): int
{
    return (new Interpreter())->execute($input)->acc;
}

function parseInput(string $filename): string
{
    $input = trim(file_get_contents(__DIR__ . "/" . $filename));
    return $input;
}

class Interpreter
{
    public int $acc = 0;

    public function execute(string $input): self
    {
        $instructions = explode(PHP_EOL, $input);
        $ip = 0;
        /** @var int[] */
        $ranInstructions = [];

        while ($ip < count($instructions) && !in_array($ip, $ranInstructions)) {
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

        return $this;
    }
}

main();
