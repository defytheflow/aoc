<?php

declare(strict_types=1);

function main(): void
{
    $input = parseInput("input.txt");

    $resultOne = solveOne($input);
    echo $resultOne, PHP_EOL;
    assert($resultOne == 11_327_140_210_986);
}

/** @param Instruction[] $input */
function solveOne(array $input): int
{
    $instructions = &$input;

    /** @var array<int, int> */
    $memory = [];
    $mask = "";

    foreach ($instructions as $instruction) {
        switch ($instruction->type) {
            case InstructionType::MASK_UPDATE:
                $mask = $instruction->value;
                break;
            case InstructionType::MEMORY_WRITE:
                $memory[$instruction->address] = applyMask($instruction->value, $mask);
                break;
        }
    }

    return array_sum(array_values($memory));
}

function applyMask(string $value, string $mask): int
{
    for ($i = 0; $i < strlen($mask); $i++) {
        if ($mask[$i] != "X") {
            $value[$i] = $mask[$i];
        }
    }

    return bindec($value);
}

/** @return Instruction[] */
function parseInput(string $filename): array
{
    $input = trim(file_get_contents(__DIR__ . "/" . $filename));
    $lines = explode(PHP_EOL, $input);

    return array_map(
        fn ($line) => str_starts_with($line, "mask") ? parseMask($line) : parseMemory($line),
        $lines
    );
}

function parseMask(string $line): Instruction
{
    $mask = explode(" = ", $line)[1];
    return new Instruction(InstructionType::MASK_UPDATE, Instruction::NO_ADDRESS, $mask);
}

function parseMemory(string $line): Instruction
{
    [$address, $value] = explode(" = ", $line);
    $value = str_pad(decbin(intval($value)), 36, "0", STR_PAD_LEFT);
    $address = intval(str_replace("]", "", str_replace("mem[", "", $address)));
    return new Instruction(InstructionType::MEMORY_WRITE, $address, $value);
}

enum InstructionType
{
    case MASK_UPDATE;
    case MEMORY_WRITE;
}

class Instruction
{
    const NO_ADDRESS = -1;

    public function __construct(
        public InstructionType $type,
        public int $address,
        public string $value
    ) {
    }
}

main();
