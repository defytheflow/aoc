import Foundation

let data = try String(contentsOfFile: "input.txt")

let result_one = solve_one(data: data)
print(result_one, result_one == 3429254)

let result_two = solve_two(data: data)
print(result_two)

func solve_one(data: String) -> Int {
    let grid = parse_input(data: data)
    var gammaRate = "", epsilonRate = ""

    for columnIndex in grid[0].indices {
        var zeros = 0, ones = 0
        for rowIndex in grid.indices {
            let digit = grid[rowIndex][columnIndex]
            if digit == "0" {
                zeros += 1
            } else if digit == "1" {
                ones += 1
            }
        }
        if zeros > ones {
            gammaRate += "0"
            epsilonRate += "1"
        } else {
            gammaRate += "1"
            epsilonRate += "0"
        }
    }

    return Int(gammaRate, radix: 2)! * Int(epsilonRate, radix: 2)!
}

func solve_two(data: String) -> Int {
    return 0
}

func parse_input(data: String) -> [[Substring]] {
    data
        .split(separator: "\n")
        .map { $0.split(separator: "") }
}
