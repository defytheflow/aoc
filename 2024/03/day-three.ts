await main();

async function main() {
    const input = await (Bun.file("./input-artyom.txt").text());
    console.log(solveTwo(input.replace("\n", "")));
}

function solve(input: string): number {
    let sum = 0;
    for (const [, a, b] of input.matchAll(/mul\((\d{1,3}),(\d{1,3})\)/g)) {
        sum += Number(a) * Number(b);
    }
    return sum;
}

function solveTwo(input: string): number {
    let sum = 0;
    let doMul = true;

    for (const [op, a, b] of input.matchAll(/mul\((\d{1,3}),(\d{1,3})\)|do\(\)|don\'t\(\)/g)) {
        if (op == "don't()") {
            doMul = false;
        }
        else if (op == "do()") {
            doMul = true;
        } 
        else if (doMul) {
            sum += Number(a) * Number(b);
        }
    }

    return sum;
}
