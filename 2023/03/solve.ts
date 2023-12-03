import fs from "node:fs";

type Input = {
  grid: string[][];
  numbers: TNumber[];
};

type TNumber = {
  digit: number;
  position: Position;
}[];

type Position = { x: number; y: number };

main();

function main() {
  const input = parseInput("input.txt");

  const resultOne = solveOne(input);
  console.log(resultOne);
  console.assert(resultOne == 544_664);

  const resultTwo = solveTwo(input);
  console.log(resultTwo);
  // console.assert(resultTwo == );
}

function solveOne(input: Input): number {
  const { grid, numbers } = input;

  return numbers
    .filter(number => {
      return number.some(entry => {
        return neighbors(entry.position).some(
          char => char != undefined && char != "." && !/\d/.test(char)
        );
      });
    })
    .map(number =>
      parseInt(
        number.reduce((s, entry) => s + entry.digit, ""),
        10
      )
    )
    .reduce((a, b) => a + b, 0);

  function neighbors(position: Position): (string | undefined)[] {
    return [
      grid[position.y][position.x - 1],
      grid[position.y][position.x + 1],
      grid[position.y - 1]?.[position.x],
      grid[position.y + 1]?.[position.x],
      grid[position.y - 1]?.[position.x - 1],
      grid[position.y + 1]?.[position.x + 1],
      grid[position.y + 1]?.[position.x - 1],
      grid[position.y - 1]?.[position.x + 1],
    ];
  }
}

function solveTwo(input: Input): number {}

function parseInput(filename: string): Input {
  const content = fs.readFileSync(filename).toString();
  return { grid: parseGrid(content), numbers: parseNumbers(content) };

  function parseGrid(content: string): Input["grid"] {
    return content.split(/\n|\r\n/).map(line => [...line]);
  }

  function parseNumbers(content: string): Input["numbers"] {
    return content.split(/\n|\r\n/).flatMap((line, y) => {
      return [...line.matchAll(/\d+/g)].map(match => {
        const x = match.index;
        const value = match[0];
        const number: TNumber = [];
        for (let i = 0; i < value.length; i++) {
          const digit = value[i];
          number.push({ digit: parseInt(digit), position: { x: x + i, y } });
        }
        return number;
      });
    });
  }
}

/*
[
  [
    { digit: 4, position: { x: 0, y: 0 } },
    { digit: 6, position: { x: 1, y: 0 } },
    { digit: 7, position: { x: 2, y: 0 } },
  ],
  ...
]
*/
