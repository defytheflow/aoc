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
  console.assert(resultTwo == 84_495_585);
}

function solveOne(input: Input): number {
  const { grid, numbers } = input;

  return numbers
    .filter(number =>
      number.some(entry =>
        neighbors(entry.position).some(char => char != "." && !/\d/.test(char))
      )
    )
    .map(toNumber)
    .reduce((a, b) => a + b, 0);

  // --------------------------------------------------------------------------------

  function neighbors(position: Position): string[] {
    return [
      grid[position.y][position.x - 1],
      grid[position.y][position.x + 1],
      grid[position.y - 1]?.[position.x],
      grid[position.y + 1]?.[position.x],
      grid[position.y - 1]?.[position.x - 1],
      grid[position.y + 1]?.[position.x + 1],
      grid[position.y + 1]?.[position.x - 1],
      grid[position.y - 1]?.[position.x + 1],
    ].filter(Boolean);
  }
}

function solveTwo(input: Input): number {
  const { grid, numbers } = input;
  const gearPositions = collectGearPositions();

  let sum = 0;

  for (const gearPosition of gearPositions) {
    const digitPositions: Position[] = [];

    for (const [y, x] of [
      [gearPosition.y, gearPosition.x - 1],
      [gearPosition.y, gearPosition.x + 1],
      [gearPosition.y - 1, gearPosition.x],
      [gearPosition.y + 1, gearPosition.x],
      [gearPosition.y - 1, gearPosition.x - 1],
      [gearPosition.y + 1, gearPosition.x + 1],
      [gearPosition.y + 1, gearPosition.x - 1],
      [gearPosition.y - 1, gearPosition.x + 1],
    ]) {
      if (/\d/.test(grid[y]?.[x])) {
        digitPositions.push({ x, y });
      }
    }

    const partNumbers: number[] = [];

    for (const number of numbers) {
      if (
        number.some(entry =>
          digitPositions.some(p => entry.position.x == p.x && entry.position.y == p.y)
        )
      ) {
        partNumbers.push(toNumber(number));
      }
    }

    if (partNumbers.length == 2) {
      sum += partNumbers[0] * partNumbers[1];
    }
  }

  return sum;

  // --------------------------------------------------------------------------------

  function collectGearPositions(): Position[] {
    return grid.flatMap(
      (row, y) =>
        row
          .map((char, x) => (char == "*" ? { x, y } : null))
          .filter(Boolean) as Position[]
    );
  }
}

function toNumber(theNumber: TNumber): number {
  return parseInt(
    theNumber.map(entry => entry.digit).reduce((a, b) => a + b, ""),
    10
  );
}

function parseInput(filename: string): Input {
  const content = fs.readFileSync(filename).toString().trimEnd();
  return { grid: parseGrid(content), numbers: parseNumbers(content) };

  // --------------------------------------------------------------------------------

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
