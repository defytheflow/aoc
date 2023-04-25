import Foundation

let data = try String(contentsOfFile: "input.txt")

let resultOne = solveOne(data: data)
print(resultOne)
assert(resultOne == 347_011)

let resultTwo = solveTwo(data: data)
print(resultTwo)
assert(resultTwo == 98_363_777)

func solveOne(data: String) -> Int {
    solve(data: data, cost: { abs($0 - $1) })
}

func solveTwo(data: String) -> Int {
    solve(data: data, cost: {
        let diff = abs($0 - $1)
        return (diff * (diff + 1)) / 2
    })
}

func solve(data: String, cost: (_ posA: Int, _ posB: Int) -> Int) -> Int {
    let positions = parseInput(data: data)

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
