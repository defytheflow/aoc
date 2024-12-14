<?php

declare(strict_types=1);

namespace Day22;

function main(): void
{
    $input = parseInput("input.txt");

    $resultOne = solveOne($input);
    echo $resultOne, PHP_EOL;
    assert($resultOne == 32_401);

    $resultTwo = solveTwo($input);
    echo $resultTwo, PHP_EOL;
    assert($resultTwo == -1);
}

/** @param Deck[] $input */
function solveOne(array $input): int
{
    [$deckA, $deckB] = $input;

    while ($deckA->hasCards() && $deckB->hasCards()) {
        $cardA = $deckA->draw();
        $cardB = $deckB->draw();

        if ($cardA > $cardB) {
            $deckA->push($cardA, $cardB);
        } else if ($cardB > $cardA) {
            $deckB->push($cardB, $cardA);
        }
    }

    $winnerDeck = $deckA->hasCards() ? $deckA : $deckB;

    return $winnerDeck->score();
}

/** @param string[] $input */
function solveTwo(array $input): int
{
    return -1;
}

/** @return Deck[] */
function parseInput(string $filename): array
{
    $input = trim(file_get_contents(__DIR__ . "/" . $filename));

    $input = preg_replace("/Player \d:/", "", $input);

    [$playerA, $playerB] = explode(str_repeat(PHP_EOL, 2), $input);

    $playerA = array_map("intval", array_filter(explode(PHP_EOL, $playerA)));
    $playerB = array_map("intval", array_filter(explode(PHP_EOL, $playerB)));

    return [new Deck($playerA), new Deck($playerB)];
}

main();

class Deck
{
    /**
     * @param int[] $cards
     */
    public function __construct(private array $cards) {}

    public function hasCards(): bool
    {
        return count($this->cards) > 0;
    }

    public function draw(): ?int
    {
        return array_shift($this->cards);
    }

    public function push(int $cardA, int $cardB): void
    {
        $this->cards[] = $cardA;
        $this->cards[] = $cardB;
    }

    public function score(): int
    {
        return array_sum(
            array_map(
                fn($card, $index) => $card * ($index + 1),
                array_reverse($this->cards),
                array_keys($this->cards),
            )
        );
    }
}
