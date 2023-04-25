import Foundation

let data = try String(contentsOfFile: "input.txt")
let input = parseInput(data: data)

let resultOne = solveOne(input: input)
print(resultOne)
assert(resultOne == 372_300)

/* let resultTwo = solveTwo(input: input) */
/* print(resultTwo) */

func solveOne(input: [Int]) -> Int {
    solve(input: input, numberOfDays: 80)
}

func solveTwo(input: [Int]) -> Int {
    solve(input: input, numberOfDays: 256)
}

func solve(input: [Int], numberOfDays: Int) -> Int {
    var timers = input
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
