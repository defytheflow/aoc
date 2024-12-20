await main();

// 307 - too low
// 329 - too high
async function main() {
    const input = await (Bun.file("./input-artyom.txt").text());
    // console.log(countSafe(parseInput(input)));
    console.log(countSafeWithExceptions(parseInput(input)));
}

function parseInput(input: string): number[][] {
    const rows: number[][] = [];

    for (const line of input.split("\n")) {
        const row = line.split(/\s+/).map(Number);
        rows.push(row);
    }

    return rows;
}

function countSafe(rows: number[][]): number {
    return rows.filter((row) => isSafe(row)).length;
}

function countSafeWithExceptions(rows: number[][]): number {
    return rows.filter((row, index) => {
        // console.log(index + 1);
        // const ret = isSafe(row, /*withException=*/ true)
        // console.log(ret);
        // return ret;
        const bruteForceResult = bruteForce(row);
        const ogResult = isSafe(row, /*withException=*/ true);
        if (bruteForceResult != ogResult) {
            console.log(index + 1, bruteForceResult, ogResult);
        }
        return bruteForceResult;
    }).length;
}

function bruteForce(row: number[]): boolean {
    for (let i = 0; i < row.length; i++) {
        const rowWithoutI = row.slice(0, i).concat(row.slice(i + 1));
        if (isSafe(rowWithoutI)) {
            return true;
        }
    }
    return false;
}

function isSafeUp(row: number[], withException = false): boolean {
    let prev = row[0];
    let usedException = false;

    for (let i = 1; i < row.length; i++) {
        const number = row[i];
        const diff = number - prev;

        if (diff >= 1 && diff <= 3) {
            prev = number;
        } else if (withException && !usedException) {
            usedException = true;
            if (i == 1) {
                const next = row[i + 1];
                const diff = next - prev;
                if (!(diff >= 1 && diff <= 3)) {
                    prev = number;
                }
            }
            // console.log("isSafeUp usedException", { prev, number });
        } else {
            return false;
        }
    }

    return true;
}

function isSafeDown(row: number[], withException = false): boolean {
  let prev = row[0];
  let usedException = false;

    for (let i = 1; i < row.length; i++) {
        const number = row[i];
        const diff = prev - number;

        if (diff >= 1 && diff <= 3) {
            prev = number;
        }
        else if (withException && !usedException) {
          usedException = true;
          if (i == 1) {
              const next = row[i + 1];
              const diff = prev - next;
              if (!(diff >= 1 && diff <= 3)) {
                  prev = number;
              }
          }
        //   console.log("isSafeDown usedException", { prev, number });
        }
        else {
            return false;
        }
    }

    return true;
}

function isSafe(array: number[], withException = false): boolean {
    if (isSafeUp(array, withException)) {
        return true;
    }
    else if (isSafeDown(array, withException)) {
        return true;
    }
    return false;
}

// 15 10 9 8 7

// 11 15 13 10 9



// 27 29 32 33 36 37 40 37