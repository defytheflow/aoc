import fs from "node:fs";

type Input = string[];

main();

function main() {
  const input = parseInput("input.txt");

  const resultOne = solveOne(input);
  console.log(resultOne);
  console.assert(resultOne == 509_167);

  const resultTwo = solveTwo(input);
  console.log(resultTwo);
  console.assert(resultTwo == Infinity);
}

function solveOne(input: Input): number {
  return input.map(hash).reduce((a, b) => a + b, 0);
}

function hash(str: string): number {
  let current = 0;

  for (const char of str) {
    const asciiCode = char.codePointAt(0);
    if (asciiCode) {
      current += asciiCode;
      current *= 17;
      current %= 256;
    }
  }

  return current;
}

function solveTwo(input: Input): number {
  return Infinity;
}

function parseInput(filename: string): Input {
  return fs
    .readFileSync(new URL(filename, import.meta.url).pathname)
    .toString()
    .trimEnd()
    .split(',');
}
