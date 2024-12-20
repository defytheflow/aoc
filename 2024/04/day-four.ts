await main();

async function main() {
    const input = await (Bun.file("./input-artyom.txt").text());
    console.log(solve(parseInput(input)))
    console.log(solveTwo(parseInput(input)))
}

function parseInput(input: string): string[][] {
    const map: string[][] = [];

    for (const line of input.split("\n")) {
        map.push([...line]);
    }

    return map;
}

function solve(map: string[][]): number {
    let count = 0;
    const checkers = [checkLeft, checkUpperLeft, checkUp, checkUpperRight, checkRight, checkLowerRight, checkDown, checkLowerLeft];

    for (let y = 0; y < map.length; y++) {
        for (let x = 0; x < map[y].length; x++) {
            if (map[y][x] == 'X') {
                for (const checker of checkers) {
                    if (checker(map, x, y)) {
                        count++;
                    }
                }
            }
        }
    }

    return count;
}

function solveTwo(map: string[][]): number {
    let count = 0;

    for (let y = 0; y < map.length; y++) {
        for (let x = 0; x < map[y].length; x++) {
            if (map[y][x] == 'A') {
                if (checkMAS(map, x, y)) {
                    count++;
                }
            }
        }
    }

    return count;
}



function checkDown(map: string[][], x: number, y: number): boolean {
    return map[y + 1]?.[x] == 'M' && map[y + 2]?.[x] == 'A' && map[y + 3]?.[x] == 'S';
}

function checkRight(map: string[][], x: number, y: number): boolean {
    return map[y]?.[x + 1] == 'M' && map[y]?.[x + 2] == 'A' && map[y]?.[x + 3] == 'S';
}

function checkLowerRight(map: string[][], x: number, y: number): boolean {
    return map[y + 1]?.[x + 1] == 'M' && map[y + 2]?.[x + 2] == 'A' && map[y + 3]?.[x + 3] == 'S';
}

function checkLowerLeft(map: string[][], x: number, y: number): boolean {
    return map[y + 1]?.[x - 1] == 'M' && map[y + 2]?.[x - 2] == 'A' && map[y + 3]?.[x - 3] == 'S';
}

function checkUp(map: string[][], x: number, y: number): boolean {
    return map[y - 1]?.[x] == 'M' && map[y - 2]?.[x] == 'A' && map[y - 3]?.[x] == 'S';
}

function checkLeft(map: string[][], x: number, y: number): boolean {
    return map[y]?.[x - 1] == 'M' && map[y]?.[x - 2] == 'A' && map[y]?.[x - 3] == 'S';
}

function checkUpperLeft(map: string[][], x: number, y: number): boolean {
    return map[y - 1]?.[x - 1] == 'M' && map[y - 2]?.[x - 2] == 'A' && map[y - 3]?.[x - 3] == 'S';
}

function checkUpperRight(map: string[][], x: number, y: number): boolean {
    return map[y - 1]?.[x + 1] == 'M' && map[y - 2]?.[x + 2] == 'A' && map[y - 3]?.[x + 3] == 'S';
}

function checkMAS(map: string[][], x: number, y: number): boolean {
    return (
        (map[y - 1]?.[x - 1] == 'M' && map[y + 1]?.[x + 1] == 'S') || 
        (map[y - 1]?.[x - 1] == 'S' && map[y + 1]?.[x + 1] == 'M')
    ) && (
        (map[y - 1]?.[x + 1] == 'S' && map[y + 1]?.[x - 1] == 'M') ||
        (map[y - 1]?.[x + 1] == 'M' && map[y + 1]?.[x - 1] == 'S')
    );
}