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

/** @param Instruction[] $input */
function solveOne(array $input): int
{
    $interpreter = new Interpreter();
    $interpreter->execute($input);
    return $interpreter->acc;
}

/** @param Instruction[] $input */
function solveTwo(array $input): int
{
    foreach ($input as $index => $instruction) {
        if ($instruction->operation == Operation::NOP) {
            $newInstruction = new Instruction(Operation::JMP, $instruction->argument);
        } elseif ($instruction->operation == Operation::JMP) {
            $newInstruction = new Instruction(Operation::NOP, $instruction->argument);
        } else {
            continue;
        }

        $input[$index] = $newInstruction;
        $interpeter = new Interpreter();

        if ($interpeter->execute($input)) {
            return $interpeter->acc;
        }

        $input[$index] = $instruction;
    }
    return -1;
}

/** @returns Instruction[] */
function parseInput(string $filename): array
{
    $input = trim(file_get_contents(__DIR__ . "/" . $filename));
    return array_map(
        function ($line) {
            [$operation, $argument] = explode(" ", $line);
            return new Instruction(Operation::from($operation), intval($argument));
        },
        explode(PHP_EOL, $input)
    );
}

enum Operation : string
{
    case NOP = "nop";
    case ACC = "acc";
    case JMP = "jmp";
}

class Instruction
{
    public function __construct(public Operation $operation, public int $argument)
    {
    }
}

class Interpreter
{
    public int $acc = 0;

    /** @param Instruction[] $instructions */
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
            $instruction = $instructions[$ip];

            switch ($instruction->operation) {
                case Operation::NOP:
                    $ip++;
                    break;
                case Operation::ACC:
                    $this->acc += $instruction->argument;
                    $ip++;
                    break;
                case Operation::JMP:
                    $ip += $instruction->argument;
                    break;
            }
        }

        return true;
    }
}

main();
