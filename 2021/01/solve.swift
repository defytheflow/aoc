import Foundation

let data = try String(contentsOfFile: "input.txt")
let input = parseInput(data: data)

let resultOne = solveOne(input: input)
print(resultOne)
assert(resultOne == 1_288)

let resultTwo = solveTwo(input: input)
print(resultTwo)
assert(resultTwo == 1_311)

func solveOne(input: [Int]) -> Int {
    solve(input: input, count: 1)
}

func solveTwo(input: [Int]) -> Int {
    solve(input: input, count: 3)
}

func solve(input measurements: [Int], count: Int) -> Int {
    zip(measurements, measurements.dropFirst(count))
        .map { ($0.0 < $0.1) ? 1 : 0 }
        .reduce(0, +)
}

func parseInput(data: String) -> [Int] {
    data
        .split(separator: "\n")
        .map { Int($0)! }
}
