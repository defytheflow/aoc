await main();

// artyom
// 5406 - too high

// daniil
// 5167 - too low

async function main() {
  const input = await (Bun.file("./example.txt").text());
  console.log(solve(...parseInput(input)));
  console.log(solveTwo(...parseInput(input)));
}

type RulesMap = Map<number, Set<number>>;

function parseInput(input: string): [RulesMap, number[][]] {
  const [rulesStr, pagesStr] = input.split("\n\n");
  const rules: RulesMap = new Map();

  for (const ruleStr of rulesStr.split("\n")) {
    const [x, y] = ruleStr.split("|").map(Number);
    if (!rules.has(x)) {
      rules.set(x, new Set());
    }
    rules.get(x)?.add(y);
  }

  const pages: number[][] = [];

  for (const pageStr of pagesStr.split('\n')) {
    pages.push(pageStr.split(',').map(Number));
  }

  return [rules, pages];
}

function solve(rulesMap: RulesMap, pages: number[][]): number {
  return pages
    .filter(page => checkRule(page, rulesMap))
    .map(page => page[Math.floor(page.length / 2)])
    .reduce((a, b) => a + b, 0);
}

function solveTwo(rulesMap: RulesMap, pages: number[][]): number {
  return pages
    .filter(page => !checkRule(page, rulesMap))
    .map(page => fixPage(page, rulesMap))
    .map(page => page[Math.floor(page.length / 2)])
    .reduce((a, b) => a + b, 0);
}

function checkRule(array: number[], rulesMap: RulesMap): boolean {
  const notFoundPages: number[] = [];

  for (let i = 0; i < array.length; i++) {
    if (!rulesMap.has(array[i])) {
      notFoundPages.push(array[i]);
      continue;
    }

    let rules = rulesMap.get(array[i]);

    for (let j = i + 1; j < array.length; j++) {
      if (!rules?.has(array[j])) {
        return false;
      }
    }

    for (const notFoundPage of notFoundPages) {
      if (rules?.has(notFoundPage)) {
        return false;
      }
    }
  }

  /*
  97, 13, 75, 29, 47
  75, 13, 29, 47
  29, 13, 47
  47, 13, 29
  29, 13
  */

  return true;
}

function fixPage(array: number[], rulesMap: RulesMap): number[] {
  const notFoundPagesIndexes: number[] = [];

  for (let i = 0; i < array.length; i++) {
    if (!rulesMap.has(array[i])) {
      notFoundPagesIndexes.push(i);
      continue;
    }

    let rules = rulesMap.get(array[i]);

    for (let k = 0; k < notFoundPagesIndexes.length; k++) {
      const notFoundPageIndex = notFoundPagesIndexes[k];
      const notFoundPage = array[notFoundPageIndex];

      if (rules?.has(notFoundPage)) {
        console.log('Swapping i and Notfound:', array, array[i], array[notFoundPageIndex], i, notFoundPageIndex)
        swap(array, i, notFoundPageIndex);
        i = notFoundPageIndex;
        notFoundPagesIndexes.splice(k, 1);
        k--;
      }
    }

    for (let j = i + 1; j < array.length; j++) {
      if (!rules?.has(array[j])) {
        // SEEMS THAT THE PROBLEM IS HERE BECAUSE WE SWAP THE SAME NUMBER AGAIN SINCE ITS NOW IN ARRAY LATER
        console.log('Did swap', array)
        swap(array, i, j);
      }
    }
  }

  return array;
}

function swap(array: number[], i: number, j: number): void {
  const tmp = array[i];
  array[i] = array[j];
  array[j] = tmp;
}