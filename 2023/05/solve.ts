import fs from "node:fs";

type Input = {
  seeds: number[];
  maps: Map[];
};

type Map = [destination: number, source: number, length: number][];

main();

function main() {
  const input = parseInput("input.txt");

  const resultOne = solveOne(input);
  console.log(resultOne);
  console.assert(resultOne == 26_273_516);

  const resultTwo = solveTwo(input);
  console.log(resultTwo);
  console.assert(resultTwo == Infinity);
}

function solveOne(input: Input): number {
  const { seeds, maps } = input;
  const seedsCopy = [...seeds];

  for (const map of maps) {
    const realMap: Record<number, number> = {};

    for (const [destination, source, length] of map) {
      for (const seed of seedsCopy) {
        if (source <= seed && seed <= source + length) {
          const index = seed - source;
          const destIndex = destination + index;
          realMap[seed] = destIndex;
        }
      }
    }

    for (const [i, seed] of seedsCopy.entries()) {
      seedsCopy[i] = realMap[seed] ?? seed;
    }
  }

  return Math.min(...seedsCopy);
}

function solveTwo(input: Input): number {
  //
}

function parseInput(filename: string): Input {
  const content = fs.readFileSync(filename).toString().trimEnd();
  const [seeds, ...maps] = content.split("\n\n");
  return { seeds: parseSeeds(seeds), maps: parseMaps(maps) };

  // --------------------------------------------------------------------------------

  function parseSeeds(seeds: string): number[] {
    return seeds.replace("seeds: ", "").split(" ").map(Number);
  }

  function parseMaps(maps: string[]): Map[] {
    return maps.map(
      map =>
        map
          .slice(map.indexOf(":") + 2)
          .split("\n")
          .map(line => line.split(" ").map(Number)) as [number, number, number][]
    );
  }
}
