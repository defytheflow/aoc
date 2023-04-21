import Foundation

let data = try String(contentsOfFile: "input.txt")

let resultOne = solveOne(data: data)
print(resultOne)
assert(resultOne == 1288)

let resultTwo = solveTwo(data: data)
print(resultTwo)
assert(resultTwo == 1311)

func solveOne(data: String) -> Int {
    solve(data: data, count: 1)
}

func solveTwo(data: String) -> Int {
    solve(data: data, count: 3)
}

func solve(data: String, count: Int) -> Int {
    let measurements = parseInput(data: data)
    var increases = 0

    for i in count..<measurements.count {
        if measurements[i] > measurements[i - count] {
            increases += 1
        }
    }

    return increases
}

func parseInput(data: String) -> [Int] {
    data
        .split(separator: "\n")
        .map { Int($0)! }
}
