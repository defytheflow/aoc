import Foundation

let data = try String(contentsOfFile: "input.txt")
let input = parseInput(data: data)

let resultOne = solveOne(input: input)
print(resultOne)
assert(resultOne == 3_429_254)

let resultTwo = solveTwo(input: input)
print(resultTwo)
assert(resultTwo == 5_410_338)

func solveOne(input numbers: [String]) -> Int {
    var gammaRate = "", epsilonRate = ""

    for columnIndex in numbers[0].indices {
        var counts: [Character: Int] = ["0": 0, "1": 0]

        for rowIndex in numbers.indices {
            let digit = numbers[rowIndex][columnIndex]
            counts[digit]! += 1
        }

        if counts["0"]! > counts["1"]! {
            gammaRate += "0"
            epsilonRate += "1"
        } else {
            gammaRate += "1"
            epsilonRate += "0"
        }
    }

    return Int(gammaRate, radix: 2)! * Int(epsilonRate, radix: 2)!
}

func solveTwo(input numbers: [String]) -> Int {
    let oxygenGeneratorRating = determine(numbers: numbers, criteria: .mostCommon)
    let co2ScrubberRating = determine(numbers: numbers, criteria: .leastCommon)
    return oxygenGeneratorRating * co2ScrubberRating
}

enum BitCriteria {
    case leastCommon, mostCommon
}

func determine(numbers: [String], criteria: BitCriteria) -> Int {
    var numbers = numbers
    var rating = ""

    for columnIndex in numbers[0].indices {
        var counts: [Character: Int] = ["0": 0, "1": 0]

        for rowIndex in numbers.indices {
            let digit = numbers[rowIndex][columnIndex]
            counts[digit]! += 1
        }

        let digit: Character
        switch criteria {
            case .mostCommon:
                digit = counts["0"]! > counts["1"]! ? "0" : "1"
            case .leastCommon:
                digit = counts["0"]! > counts["1"]! ? "1" : "0"
        }
        numbers = numbers.filter { $0[columnIndex] == digit }

        if numbers.count == 1 {
            rating = numbers[0]
            break
        }
    }

    return Int(rating, radix: 2)!
}

func parseInput(data: String) -> [String] {
    data
        .split(separator: "\n")
        .map { String($0) }
}
