import fs from "node:fs";

type Input = number[][];

main();

function main() {
  const input = parseInput("input.txt");

  const resultOne = solveOne(input);
  console.log(resultOne);
  console.assert(resultOne == 1_934_898_178);

  const resultTwo = solveTwo(input);
  console.log(resultTwo);
  console.assert(resultTwo == 1_129);
}

function solveOne(input: Input): number {
  let sum = 0;

  for (const line of input) {
    const matrix: number[][] = [];
    matrix.push([...line]);
    fillMatrix(line, matrix);

    matrix.at(-1).push(0);

    for (let i = matrix.length - 1; i > 0; i--) {
      const row = matrix[i];
      const aboveRow = matrix[i - 1];
      aboveRow.push(row.at(-1) + aboveRow.at(-1));
    }

    sum += matrix[0].at(-1);
  }

  return sum;
}

function solveTwo(input: Input): number {
  let sum = 0;

  for (const line of input) {
    const matrix: number[][] = [];
    matrix.push([...line]);
    fillMatrix(line, matrix);

    matrix.at(-1).unshift(0);

    for (let i = matrix.length - 1; i > 0; i--) {
      const row = matrix[i];
      const aboveRow = matrix[i - 1];
      aboveRow.unshift(aboveRow[0] - row[0]);
    }

    sum += matrix[0][0];
  }

  return sum;
}

function fillMatrix(current: number[], matrix: number[][]) {
  const next: number[] = [];

  for (let i = 0; i < current.length - 1; i++) {
    const diff = current[i + 1] - current[i];
    next.push(diff);
  }

  matrix.push(next);
  if (next.some(n => n != 0)) {
    fillMatrix(next, matrix);
  }
}

function parseInput(filename: string): Input {
  return fs
    .readFileSync(new URL(filename, import.meta.url).pathname)
    .toString()
    .trimEnd()
    .split(/\n|\r\n/)
    .map(line => line.split(" ").map(Number));
}
