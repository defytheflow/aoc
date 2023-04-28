import Foundation

let input = parseInput(data: try String(contentsOfFile: "input.txt"))

let resultOne = solveOne(input: input)
print(resultOne)
assert(resultOne == 265_527)

let resultTwo = solveTwo(input: input)
print(resultTwo)
assert(resultTwo == 3_969_823_589)

func solveOne(input: [[PairCharacter]]) -> Int {
    input
        .compactMap { firstCorruptedCharacter(in: $0)?.errorScore }
        .reduce(0, +)
}

func solveTwo(input: [[PairCharacter]]) -> Int {
    input
        .filter { firstCorruptedCharacter(in: $0) == nil }
        .map { line in
            autocomplete(line: line)
                .reduce(0) { $0 * 5 + $1.autocompleteScore }
        }
        .sorted()
        .middle!
}

func firstCorruptedCharacter(in line: [PairCharacter]) -> PairCharacter? {
    var stack = [PairCharacter]()

    for char in line {
        if char.isOpening {
            stack.append(char)
        } else {
            guard let lastChar = stack.popLast(), lastChar.formsPair(with: char) else {
                return char
            }
        }
    }

    return nil
}

func autocomplete(line: [PairCharacter]) -> [PairCharacter] {
    var stack = [PairCharacter]()

    for char in line {
        if char.isOpening {
            stack.append(char)
        } else {
            stack.removeLast()
        }
    }

    return stack.reversed()
}

struct PairCharacter {
    let type: PairCharacterType
    let isOpening: Bool

    init?(rawValue: Character) {
        switch rawValue {
        case "(", ")":
            type = .paren
            isOpening = (rawValue == "(")
        case "[", "]":
            type = .bracket
            isOpening = (rawValue == "[")
        case "{", "}":
            type = .curly
            isOpening = (rawValue == "{")
        case "<", ">":
            type = .angle
            isOpening = (rawValue == "<")
        default:
            return nil
        }
    }

    var errorScore: Int {
        switch type {
        case .paren: return 3
        case .bracket: return 57
        case .curly: return 1197
        case .angle: return 25137
        }
    }

    var autocompleteScore: Int {
        switch type {
        case .paren: return 1
        case .bracket: return 2
        case .curly: return 3
        case .angle: return 4
        }
    }

    func formsPair(with other: PairCharacter) -> Bool {
        self.type == other.type && self.isOpening != other.isOpening
    }

    enum PairCharacterType {
        case paren, bracket, curly, angle
    }
}

extension Array {
    /// The middle element of the array.
    var middle: Element? {
        guard count > 0 else {
            return nil
        }
        return self[(count % 2 == 0) ? (count / 2 - 1) : count / 2]
    }
}

func parseInput(data: String) -> [[PairCharacter]] {
    data
        .trimmingCharacters(in: .newlines)
        .components(separatedBy: .newlines)
        .map { Array($0).compactMap(PairCharacter.init) }
}
