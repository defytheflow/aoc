import fs from "node:fs";

type Input = string;
type Race = { time: number; distance: number };

main();

function main() {
  const input = parseInput("input.txt");

  const resultOne = solveOne(input);
  console.log(resultOne);
  console.assert(resultOne == 1_159_152);

  const resultTwo = solveTwo(input);
  console.log(resultTwo);
  console.assert(resultTwo == 41_513_103);
}

function solveOne(input: Input): unknown {
  return parseRaces(input)
    .map(calculateNumberOfWins)
    .reduce((a, b) => a * b, 1);

  function parseRaces(content: string): Race[] {
    const matrix = content
      .split(/\n|\r\n/)
      .map(line => line.slice("Distance:".length).trim().split(/\s+/).map(Number));

    const races: Race[] = [];
    for (let i = 0; i < matrix[0].length; i++) {
      races.push({ time: matrix[0][i], distance: matrix[1][i] });
    }

    return races;
  }
}

function solveTwo(input: Input): unknown {
  return calculateNumberOfWins(parseRace(input));

  function parseRace(content: string): Race {
    const [time, distance] = content
      .split(/\n|\r\n/)
      .map(line => parseInt(line.slice("Distance:".length).replaceAll(" ", ""), 10));

    return { time, distance };
  }
}

function calculateNumberOfWins(race: Race): number {
  const { time, distance } = race;
  let numberOfWins = 0;

  for (let speed = 0; speed < time; speed++) {
    const timeLeft = time - speed;
    const resultingDistance = speed * timeLeft;

    if (resultingDistance > distance) {
      numberOfWins += 1;
    }
  }

  return numberOfWins;
}

function parseInput(filename: string): Input {
  return fs
    .readFileSync(new URL(filename, import.meta.url).pathname)
    .toString()
    .trimEnd();
}
