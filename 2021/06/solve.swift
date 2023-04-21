import Foundation

let data = try String(contentsOfFile: "input.txt")

let resultOne = solveOne(data: data)
print(resultOne)
assert(resultOne == 372_300)

/* let resultTwo = solveTwo(data: data) */
/* print(resultTwo) */

func solveOne(data: String) -> Int {
    solve(data: data, numberOfDays: 80)
}

func solveTwo(data: String) -> Int {
    solve(data: data, numberOfDays: 256)
}

func solve(data: String, numberOfDays: Int) -> Int {
    var timers = parseInput(data: data)
    let resetTimer = 6
    let newTimer = 8

    for _ in 1...numberOfDays {
        for index in 0..<timers.count {
            if timers[index] == 0 {
                timers[index] = resetTimer
                timers.append(newTimer)
            } else {
                timers[index] -= 1
            }
        }
    }

    return timers.count
}

func parseInput(data: String) -> [Int] {
    data
        .trimmingCharacters(in: .newlines)
        .split(separator: ",")
        .map { Int($0)! }
}
