const input = await(Bun.file("./example.txt").text());
console.log(parseInput(input));

function parseInput(input: string): number[][] {
    const rows: number[][] = [];

    for (const line of input.split("\n")) {
        const row = line.split(/\s+/).map(Number);
        rows.push(row);
    }

    return rows;
}