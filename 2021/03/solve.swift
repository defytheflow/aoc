import Foundation

let data = try String(contentsOfFile: "input.txt")
let input = parseInput(data: data)

let resultOne = solveOne(input: input)
print(resultOne)
assert(resultOne == 3_429_254)

let resultTwo = solveTwo(input: input)
print(resultTwo)
assert(resultTwo == 5_410_338)

func solveOne(input: [String]) -> Int {
    let numberOfBits = input[0].count
    let numbers = input.compactMap { Int($0, radix: 2) }
    var gamma = 0, epsilon = 0, mask = 1

    for _ in 1...numberOfBits {
        let numberOfOnes = numbers.filter { $0 & mask == mask }.count
        if numberOfOnes > numbers.count / 2 {
            gamma |= mask
        } else {
            epsilon |= mask
        }
        mask <<= 1
    }

    return gamma * epsilon
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
        var counts = [Character: Int]()

        for rowIndex in numbers.indices {
            let digit = numbers[rowIndex][columnIndex]
            counts[digit, default: 0] += 1
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
        .trimmingCharacters(in: .newlines)
        .components(separatedBy: .newlines)
}
