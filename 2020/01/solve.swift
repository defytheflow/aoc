import Foundation

let data = try String(contentsOfFile: "input.txt")
let input = parseInput(data: data)

let resultOne = solveOne(input: input)
print(resultOne)
assert(resultOne == 1_018_944)

let resultTwo = solveTwo(input: input)
print(resultTwo)
assert(resultTwo == 8_446_464)

func solveOne(input numbers: [Int]) -> Int {
    let sum = 2020
    var seen = Set<Int>()

    for number in numbers {
        let diff = sum - number
        if seen.contains(diff) {
            return number * diff
        }
        seen.insert(number)
    }

    fatalError("Control flow should never reach here")
}

func solveTwo(input numbers: [Int]) -> Int {
    let sum = 2020

    for i in 0..<numbers.count {
        for j in (i+1)..<numbers.count {
            for k in (j+1)..<numbers.count {
                if numbers[i] + numbers[j] + numbers[k] == sum {
                    return numbers[i] * numbers[j] * numbers[k]
                }
            }
        }
    }

    fatalError("Control flow should never reach here")
}

func parseInput(data: String) -> [Int] {
    data
        .split(separator: "\n")
        .map { Int($0)! }
}
