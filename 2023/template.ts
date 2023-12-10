import fs from "node:fs";

type Input = string;

main();

function main() {
  const input = parseInput("input.txt");

  const resultOne = solveOne(input);
  console.log(resultOne);
  console.assert(resultOne == Infinity);

  const resultTwo = solveTwo(input);
  console.log(resultTwo);
  console.assert(resultTwo == Infinity);
}

function solveOne(input: Input): number {
  return Infinity;
}

function solveTwo(input: Input): number {
  return Infinity;
}

function parseInput(filename: string): Input {
  return fs
    .readFileSync(new URL(filename, import.meta.url).pathname)
    .toString()
    .trimEnd();
}
