import fs from "node:fs";

type Input = string[];

main();

function main() {
  const input = parseInput("input.txt");

  const resultOne = solveOne(input);
  console.log(resultOne);
  console.assert(resultOne == 53_334);

  const resultTwo = solveTwo(input);
  console.log(resultTwo);
  console.assert(resultTwo == 52_834);
}

function solveOne(input: Input): number {
  return input
    .map(line => line.match(/\d/g))
    .map(numbers => numbers.at(0) + numbers.at(-1))
    .map(Number)
    .reduce((a, b) => a + b, 0);
}

function solveTwo(input: Input): number {
  const numbersMap = {
    one: 1,
    two: 2,
    three: 3,
    four: 4,
    five: 5,
    six: 6,
    seven: 7,
    eight: 8,
    nine: 9,
  };

  return solveOne(input.map(parseDigits));

  // --------------------------------------------------------------------------------

  function parseDigits(line: string) {
    let parsed = "";
    let curr = "";

    for (const char of line) {
      if (/\d/.test(char)) {
        parsed += char;
        curr = "";
      } else {
        curr += char;
        for (const [key, value] of Object.entries(numbersMap)) {
          if (curr.match(key)) {
            parsed += value;
            curr = "";
            break;
          }
        }
      }
    }

    return parsed;
  }
}

function parseInput(filename: string): Input {
  return fs
    .readFileSync(new URL(filename, import.meta.url).pathname)
    .toString()
    .trimEnd()
    .split(/\n|\r\n/);
}
