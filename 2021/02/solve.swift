import Foundation

let data = try String(contentsOfFile: "input.txt")

let result_one = solve_one(data: data)
print(result_one)
assert(result_one == 1_868_935)

let result_two = solve_two(data: data)
print(result_two)
assert(result_two == 1_965_970_888)

func solve_one(data: String) -> Int {
    let commands = parse_input(data: data)
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

func solve_two(data: String) -> Int {
    let commands = parse_input(data: data)
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

func parse_input(data: String) -> [(Substring, Int)] {
    data
        .split(separator: "\n")
        .map({ $0.split(separator: " ") })
        .map({ ($0[0], Int($0[1])!) })
}
