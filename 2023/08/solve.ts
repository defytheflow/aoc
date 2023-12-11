import fs from "node:fs";

type Input = {
  instruction: string;
  network: Record<string, [string, string]>;
};

main();

function main() {
  const input = parseInput("input2.txt");

  const resultOne = solveOne(input);
  console.log(resultOne);
  console.assert(resultOne == 19_241);

  const resultTwo = solveTwo(input);
  console.log(resultTwo);
  console.assert(resultTwo == 9_606_140_307_013);
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
  const { instruction, network } = input;

  const currentNodes = Object.keys(network).filter(node => node.endsWith("A"));
  const steps = currentNodes.map(node => countSteps(node, network, instruction));

  return findLCM(steps);

  // --------------------------------------------------------------------------------

  function countSteps(
    node: string,
    network: Input["network"],
    instruction: Input["instruction"]
  ): number {
    let currentNode = node;
    let currentInstructionIndex = 0;
    let steps = 0;

    while (!currentNode.endsWith("Z")) {
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

  function findLCM(numbers: number[]): number {
    // Greatest Common Divisor
    function gcd(a: number, b: number): number {
      return b == 0 ? a : gcd(b, a % b);
    }

    // Least Common Multiple
    function lcm(a: number, b: number): number {
      return (a * b) / gcd(a, b);
    }

    return numbers.reduce((acc, val) => lcm(acc, val), 1);
  }
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
