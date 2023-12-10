import fs from "node:fs";

type Input = string[][];

type Position = { x: number; y: number };

main();

function main() {
  const input = parseInput("input.txt");

  const resultOne = solveOne(input);
  console.log(resultOne);
  console.assert(resultOne == 7_107);

  const resultTwo = solveTwo(input);
  console.log(resultTwo);
  console.assert(resultTwo == Infinity);
}

function solveOne(input: Input): number {
  const map = input;
  const startPos = findStartPosition(map);
  const currentPath: Position[] = [startPos];

  findPath(currentPath, map);

  const steps = currentPath.map((_, index) => {
    const firstIndex = 0;
    const lastIndex = currentPath.length - 1;

    const diffWithFirst = index - firstIndex;
    const diffWithLast = lastIndex - index;

    return Math.max(diffWithFirst, diffWithLast);
  });

  return Math.min(...steps);

  function findPath(currentPath: Position[], map: Input): boolean {
    if (currentPath.length > 1) {
      const firstPos = currentPath[0];
      const lastPos = currentPath[currentPath.length - 1];

      if (map[firstPos.y][firstPos.x] == "S" && map[lastPos.y][lastPos.x] == "S") {
        return true;
      }
    }

    let nextMoves = collectNextMoves(currentPath[currentPath.length - 1], map);

    if (currentPath.length > 1) {
      const prevPos = currentPath[currentPath.length - 2];
      nextMoves = nextMoves.filter(p => p.x != prevPos.x || p.y != prevPos.y);
    }

    for (const move of nextMoves) {
      currentPath.push(move);

      if (findPath(currentPath, map)) {
        return true;
      }

      currentPath.pop();
    }

    return false;
  }

  function collectNextMoves(currentPos: Position, map: Input): Position[] {
    const nextMoves: Position[] = [];
    const currentPipe = map[currentPos.y][currentPos.x];

    const topPipe = map[currentPos.y - 1]?.[currentPos.x];
    if (topPipe) {
      if (
        ["S", "|", "L", "J"].includes(currentPipe) &&
        ["S", "|", "7", "F"].includes(topPipe)
      ) {
        nextMoves.push({ x: currentPos.x, y: currentPos.y - 1 });
      }
    }

    const bottomPipe = map[currentPos.y + 1]?.[currentPos.x];
    if (bottomPipe) {
      if (
        ["S", "|", "7", "F"].includes(currentPipe) &&
        ["S", "|", "J", "L"].includes(bottomPipe)
      ) {
        nextMoves.push({ x: currentPos.x, y: currentPos.y + 1 });
      }
    }

    const leftPipe = map[currentPos.y]?.[currentPos.x - 1];
    if (leftPipe) {
      if (
        ["S", "-", "7", "J"].includes(currentPipe) &&
        ["S", "-", "L", "F"].includes(leftPipe)
      ) {
        nextMoves.push({ x: currentPos.x - 1, y: currentPos.y });
      }
    }

    const rightPipe = map[currentPos.y]?.[currentPos.x + 1];
    if (rightPipe) {
      if (
        ["S", "-", "L", "F"].includes(currentPipe) &&
        ["S", "-", "7", "J"].includes(rightPipe)
      ) {
        nextMoves.push({ x: currentPos.x + 1, y: currentPos.y });
      }
    }

    return nextMoves;
  }

  function findStartPosition(map: Input): Position {
    for (let y = 0; y < map.length; y++) {
      const row = map[y];
      for (let x = 0; x < row.length; x++) {
        if (row[x] == "S") {
          return { x, y };
        }
      }
    }
    throw new Error("Unreachable");
  }
}

function solveTwo(input: Input): number {
  return Infinity;
}

function parseInput(filename: string): Input {
  return fs
    .readFileSync(new URL(filename, import.meta.url).pathname)
    .toString()
    .trimEnd()
    .split(/\n|\r\n/)
    .map(line => [...line]);
}
