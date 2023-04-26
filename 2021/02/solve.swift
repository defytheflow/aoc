import Foundation

let data = try String(contentsOfFile: "input.txt")
let input = parseInput(data: data)

let resultOne = solveOne(input: input)
print(resultOne)
assert(resultOne == 1_868_935)

let resultTwo = solveTwo(input: input)
print(resultTwo)
assert(resultTwo == 1_965_970_888)

func solveOne(input: [(command: String, count: Int)]) -> Int {
    var depth = 0, position = 0

    for (command, count) in input {
        switch command {
        case "forward":
            position += count
        case "down":
            depth += count
        case "up":
            depth -= count
        default:
            fatalError("Unknown command")
        }
    }

    return depth * position
}

func solveTwo(input: [(command: String, count: Int)]) -> Int {
    var depth = 0, position = 0, aim = 0

    for (command, count) in input {
        switch command {
        case "forward":
            position += count
            depth += aim * count
        case "down":
            aim += count
        case "up":
            aim -= count
        default:
            fatalError("Unknown command")
        }
    }

    return depth * position
}

func parseInput(data: String) -> [(command: String, count: Int)] {
    data
        .trimmingCharacters(in: .newlines)
        .components(separatedBy: .newlines)
        .map {
            let parts = $0.split(separator: " ")
            return (String(parts[0]), Int(parts[1])!)
        }
}
