import Foundation

let data = try String(contentsOfFile: "input.txt")

let resultOne = solveOne(data: data)
print(resultOne)
assert(resultOne == 1_868_935)

let resultTwo = solveTwo(data: data)
print(resultTwo)
assert(resultTwo == 1_965_970_888)

func solveOne(data: String) -> Int {
    let commands = parseInput(data: data)
    var depth = 0, position = 0

    for (command, count) in commands {
        switch command {
        case "forward":
            position += count
        case "down":
            depth += count
        case "up":
            depth -= count
        default:
            break
        }
    }

    return depth * position
}

func solveTwo(data: String) -> Int {
    let commands = parseInput(data: data)
    var depth = 0, position = 0, aim = 0

    for (command, count) in commands {
        switch command {
        case "forward":
            position += count
            depth += aim * count
        case "down":
            aim += count
        case "up":
            aim -= count
        default:
            break
        }
    }

    return depth * position
}

func parseInput(data: String) -> [(Substring, Int)] {
    data
        .split(separator: "\n")
        .map { $0.split(separator: " ") }
        .map { ($0[0], Int($0[1])!) }
}
