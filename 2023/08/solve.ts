import fs from "node:fs";

type Input = {
  instruction: string;
  network: Record<string, [string, string]>;
};

main();

function main() {
  const input = parseInput("input.txt");

  const resultOne = solveOne(input);
  console.log(resultOne);
  console.assert(resultOne == 19_241);

  const resultTwo = solveTwo(input);
  console.log(resultTwo);
  console.assert(resultTwo == Infinity);
}

function solveOne(input: Input): number {
  const { instruction, network } = input;

  let currentInstructionIndex = 0;
  let currentNode = "AAA";
  let steps = 0;

  while (currentNode != "ZZZ") {
    steps += 1;
    const currentInstruction = instruction[currentInstructionIndex];
    if (currentInstruction == "L") {
      currentNode = network[currentNode][0];
    } else if (currentInstruction == "R") {
      currentNode = network[currentNode][1];
    }
    currentInstructionIndex = (currentInstructionIndex + 1) % instruction.length;
  }

  return steps;
}

function solveTwo(input: Input): number {
  return Infinity;
}

function parseInput(filename: string): Input {
  const content = fs
    .readFileSync(new URL(filename, import.meta.url).pathname)
    .toString()
    .trimEnd();
  const [instruction, network] = content.split("\n\n") as [string, string];
  return { instruction, network: parseNetwork(network) };

  // --------------------------------------------------------------------------------

  function parseNetwork(network: string): Input["network"] {
    return Object.fromEntries(
      network.split("\n").map(line => {
        const [node, nodes] = line.split(" = ");
        return [node, nodes.slice(1, -1).split(", ")] as [string, [string, string]];
      })
    );
  }
}
