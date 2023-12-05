import fs from "node:fs";

type Input = [number[], number[]][];

main();

function main() {
  const input = parseInput("input.txt");

  const resultOne = solveOne(input);
  console.log(resultOne);
  console.assert(resultOne == 18_619);

  const resultTwo = solveTwo(input);
  console.log(resultTwo);
  console.assert(resultTwo == 8_063_216);
}

function solveOne(input: Input): number {
  return input
    .map(([winning, mine]) => mine.filter(n => winning.includes(n)))
    .reduce((total, winning) => total + Math.floor(2 ** (winning.length - 1)), 0);
}

function solveTwo(input: Input): number {
  const cardNumbers = Array.from({ length: input.length }, (_, i) => i + 1);

  const wonCardNumbers: Record<number, number[]> = {};
  for (const [index, [winning, mine]] of input.entries()) {
    const myWinning = mine.filter(n => winning.includes(n));
    wonCardNumbers[index + 1] = myWinning.map((_, i) => index + 1 + i + 1);
  }

  for (let i = 0; i < cardNumbers.length; i++) {
    const cardNumber = cardNumbers[i];
    cardNumbers.push(...wonCardNumbers[cardNumber]);
  }

  return cardNumbers.length;
}

function parseInput(filename: string): Input {
  return fs
    .readFileSync(filename)
    .toString()
    .trimEnd()
    .split(/\n|\r\n/)
    .map(
      line =>
        line
          .slice(line.indexOf(":") + 2)
          .split(" | ")
          .map(part => part.split(" ").filter(Boolean).map(Number)) as [
          number[],
          number[]
        ]
    );
}
