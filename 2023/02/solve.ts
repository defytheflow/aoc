import fs from "node:fs";

enum Color {
  RED = "red",
  GREEN = "green",
  BLUE = "blue",
}

type Game = { id: number; rounds: Round[] };
type Round = { number: number; color: Color };
type Input = Game[];

main();

function main() {
  const input = parseInput("input.txt");

  const resultOne = solveOne(input);
  console.log(resultOne);
  console.assert(resultOne == 2776);

  const resultTwo = solveTwo(input);
  console.log(resultTwo);
  console.assert(resultTwo == 68_638);
}

function solveOne(input: Input): number {
  const red = 12,
    green = 13,
    blue = 14;

  return input
    .filter(game =>
      game.rounds.every(round => {
        switch (round.color) {
          case Color.RED:
            return round.number <= red;
          case Color.GREEN:
            return round.number <= green;
          case Color.BLUE:
            return round.number <= blue;
        }
      })
    )
    .reduce((total, game) => total + game.id, 0);
}

function solveTwo(input: Input): number {
  const maxRound = (max: Round, round: Round) =>
    round.number > max.number ? round : max;

  return input
    .map(game => ({
      [Color.RED]: game.rounds.filter(round => round.color == Color.RED).reduce(maxRound)
        .number,
      [Color.GREEN]: game.rounds
        .filter(round => round.color == Color.GREEN)
        .reduce(maxRound).number,
      [Color.BLUE]: game.rounds
        .filter(round => round.color == Color.BLUE)
        .reduce(maxRound).number,
    }))
    .map(result => result[Color.RED] * result[Color.GREEN] * result[Color.BLUE])
    .reduce((a, b) => a + b, 0);
}

function parseInput(filename: string): Input {
  return fs
    .readFileSync(filename)
    .toString()
    .split(/\n|\r\n/)
    .map(line => {
      line = line.slice(5);
      const indexOfColon = line.indexOf(":");
      const gameId = parseInt(line.slice(0, indexOfColon), 10);
      line = line.slice(indexOfColon + 2);
      return {
        id: gameId,
        rounds: line.split(/; ?/).flatMap(subset =>
          subset.split(/, ?/).map(subset => {
            const [number, color] = subset.split(" ");
            return { number: parseInt(number, 10), color: color as Color };
          })
        ),
      };
    });
}
