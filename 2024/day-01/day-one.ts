await main();

async function main() {
  const input = await(Bun.file("./input-daniil.txt").text());
  console.log(getSortedTotalDistance(...parseInput(input)));

  console.log(getSortedSimilarity(...adjustInput(...parseInput(input))));
}  

function parseInput(input: string): [number[], number[]] {
    const array1: number[] = [];
    const array2: number[] = [];

    for (const line of input.split("\n")) {
        const [a, b] = line.split(/\s+/).map(Number);
        array1.push(a);
        array2.push(b);
    }

    return [array1, array2];
}

function adjustInput(array1: number[], array2: number[]): [number[], Record<number, number>] {
  const counts: Record<number, number> = {};
  
  for (const number of array2) {
    if (!(number in counts)) {
      counts[number] = 0;
    }
    counts[number]++;
  }
  
  return [array1, counts];
}


function getSortedTotalDistance(array1:number[], array2:number[]): number {
  // Sorting arrays from smallest to largest
  array1.sort((a, b) => a - b);
  array2.sort((a, b) => a - b);

  var TotalDistance = 0;
  // Assumes array1 len = array2 len
  for (var i = 0; i < array1.length; i++) {
    TotalDistance += Math.abs(array1[i] - array2[i]);
  }

  return TotalDistance
}

function getSortedSimilarity(array: number[], map: Record<number, number>): number {
  var TotalSimilarity = 0;
  
  for (var i = 0; i < array.length; i++) {
    var num = array[i];
    var count = map[num];
    if (count == undefined) {
      count = 0;
    }
    TotalSimilarity += num * count;
  }

  return TotalSimilarity;
}