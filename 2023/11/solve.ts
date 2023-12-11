import fs from "node:fs";

type Input = string[][];
type Position = { x: number; y: number };

main();

function main() {
  const input = parseInput("input.txt");

  const resultOne = solveOne(input);
  console.log(resultOne);
  console.assert(resultOne == 9_742_154);

  const resultTwo = solveTwo(input);
  console.log(resultTwo);
  console.assert(resultTwo == 411_142_919_886);
}

function solveOne(input: Input): number {
  const universe = expand(input);
  const galaxies = findGalaxies(universe);
  const paths = findShortestPaths(galaxies);
  return paths.reduce((a, b) => a + b, 0);

  // --------------------------------------------------------------------------------

  function expand(input: Input): Input {
    const expanded: Input = [];

    // Expand rows
    for (const row of input) {
      if (row.every(ch => ch == ".")) {
        expanded.push([...row]);
      }
      expanded.push([...row]);
    }

    // Expand columns
    for (let i = 0, offset = 0; i < input[0].length; i++) {
      const index = i + offset;
      if (expanded.every(row => row[index] == ".")) {
        for (const row of expanded) {
          row.splice(index, 0, ".");
        }
        offset++;
      }
    }

    return expanded;
  }
}

function solveTwo(input: Input): number {
  const galaxies = findGalaxies(input);
  const { rows, columns } = findEmptyRowsAndColumns(input);
  const adjustedGalaxies = adjustGalaxies(galaxies, rows, columns);
  const paths = findShortestPaths(adjustedGalaxies);
  return paths.reduce((a, b) => a + b, 0);

  function adjustGalaxies(
    galaxies: Position[],
    rows: number[],
    columns: number[]
  ): Position[] {
    const newGalaxies = galaxies.map(galaxy => ({ ...galaxy }));

    for (const galaxy of newGalaxies) {
      const greaterThanXCount = columns.filter(x => galaxy.x > x).length;
      const greaterThanYCount = rows.filter(y => galaxy.y > y).length;

      galaxy.x += greaterThanXCount * 1_000_000 - greaterThanXCount;
      galaxy.y += greaterThanYCount * 1_000_000 - greaterThanYCount;
    }

    return newGalaxies;
  }

  // --------------------------------------------------------------------------------

  function findEmptyRowsAndColumns(input: Input): { rows: number[]; columns: number[] } {
    const rows: number[] = [];
    const columns: number[] = [];

    for (const [i, row] of input.entries()) {
      if (row.every(ch => ch == ".")) {
        rows.push(i);
      }
    }

    for (let i = 0; i < input[0].length; i++) {
      if (input.every(row => row[i] == ".")) {
        columns.push(i);
      }
    }

    return { rows, columns };
  }
}

function findGalaxies(universe: Input): Position[] {
  const pairs: Position[] = [];

  for (const [y, row] of universe.entries()) {
    for (const [x, ch] of row.entries()) {
      if (ch == "#") {
        pairs.push({ x, y });
      }
    }
  }

  return pairs;
}

function findShortestPaths(galaxies: Position[]): number[] {
  const paths: number[] = [];

  for (let i = 0; i < galaxies.length; i++) {
    const galaxyA = galaxies[i];

    for (let j = i + 1; j < galaxies.length; j++) {
      const galaxyB = galaxies[j];
      const path = Math.abs(galaxyB.x - galaxyA.x) + Math.abs(galaxyB.y - galaxyA.y);
      paths.push(path);
    }
  }

  return paths;
}

function parseInput(filename: string): Input {
  return fs
    .readFileSync(new URL(filename, import.meta.url).pathname)
    .toString()
    .trimEnd()
    .split(/\n|\r\n/)
    .map(line => [...line]);
}
