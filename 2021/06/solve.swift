import Foundation

let data = try String(contentsOfFile: "input.txt")

let result_one = solve_one(data: data)
print(result_one)
assert(result_one == 372_300)

/* let result_two = solve_two(data: data) */
/* print(result_two) */

func solve_one(data: String) -> Int {
    solve(data: data, numberOfDays: 80)
}

func solve_two(data: String) -> Int {
    solve(data: data, numberOfDays: 256)
}

func solve(data: String, numberOfDays: Int) -> Int {
    var timers = parse_input(data: data)
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

func parse_input(data: String) -> [Int] {
    data
        .trimmingCharacters(in: .newlines)
        .split(separator: ",")
        .map { Int($0)! }
}
