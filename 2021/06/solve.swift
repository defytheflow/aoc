import Foundation

let data = try String(contentsOfFile: "input.txt")
let input = parseInput(data: data)

let resultOne = solveOne(input: input)
print(resultOne)
assert(resultOne == 372_300)

let resultTwo = solveTwo(input: input)
print(resultTwo)
assert(resultTwo == 1_675_781_200_288)

func solveOne(input: [Int]) -> Int {
    solve(input: input, for: 80)
}

func solveTwo(input: [Int]) -> Int {
    solve(input: input, for: 256)
}

func solve(input: [Int], for numberOfDays: Int) -> Int {
    var ages = input.reduce(into: [Int: Int](), { dict, age in
        dict[age, default: 0] += 1
    })

    for _ in 1...numberOfDays {
        let newFish = ages[0, default: 0]
        for i in 1...8 {
            ages[i - 1] = ages[i, default: 0]
        }
        ages[6, default: 0] += newFish
        ages[8] = newFish
    }

    return ages.values.reduce(0, +)
}

func parseInput(data: String) -> [Int] {
    data
        .trimmingCharacters(in: .newlines)
        .components(separatedBy: ",")
        .compactMap(Int.init)
}
