import Foundation

let data = try String(contentsOfFile: "input.txt")
let input = parseInput(data: data)

let resultOne = solveOne(input: input)
print(resultOne)
assert(resultOne == 347_011)

let resultTwo = solveTwo(input: input)
print(resultTwo)
assert(resultTwo == 98_363_777)

func solveOne(input: [Int]) -> Int {
    solve(input: input, cost: { abs($0 - $1) })
}

func solveTwo(input: [Int]) -> Int {
    solve(input: input, cost: {
        let diff = abs($0 - $1)
        return (diff * (diff + 1)) / 2
    })
}

func solve(input positions: [Int], cost: (_ posA: Int, _ posB: Int) -> Int) -> Int {
    let minPos = positions.min()!
    let maxPos = positions.max()!

    return (minPos...maxPos)
        .map { uniquePos in
            positions
                .map { cost($0, uniquePos) }
                .reduce(0, +)
        }
        .sorted()
        .first!
}

func parseInput(data: String) -> [Int] {
    data
        .trimmingCharacters(in: .newlines)
        .split(separator: ",")
        .map { Int($0)! }
}
