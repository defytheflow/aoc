import Foundation

let data = try String(contentsOfFile: "input.txt")

let resultOne = solveOne(data: data)
print(resultOne)
assert(resultOne == 72_770)

let resultTwo = solveTwo(data: data)
print(resultTwo)
assert(resultTwo == 13_912)

func solveOne(data: String) -> Int {
    var (numbers, boards) = parseInput(data: data)

    for number in numbers {
        for i in boards.indices {
            boards[i].mark(number)
            if boards[i].hasWon() {
                return boards[i].score(winningNumber: number)
            }
        }
    }

    fatalError("Control flow should never reach here")
}

func solveTwo(data: String) -> Int {
    var (numbers, boards) = parseInput(data: data)
    var winningBoardsIndices = Set<Int>()

    for number in numbers {
        for i in boards.indices {
            if winningBoardsIndices.contains(i) {
                continue
            }
            boards[i].mark(number)
            if boards[i].hasWon() {
                winningBoardsIndices.insert(i)
                if winningBoardsIndices.count == boards.count {
                    return boards[i].score(winningNumber: number)
                }
            }
        }
    }

    fatalError("Control flow should never reach here")
}

struct Board {
    struct Cell {
        let value: Int
        var isMarked = false
    }

    private var cells: [[Cell]]

    init(data: [Int]) {
        cells = []

        var row = [Cell]()
        for (i, number) in data.enumerated() {
            if i % 5 == 0 {
                if !row.isEmpty {
                    cells.append(row)
                    row = []
                }
            }
            row.append(Cell(value: number))
        }
        cells.append(row)
    }

    mutating func mark(_ number: Int) {
        for rowIndex in cells.indices {
            for columnIndex in cells[rowIndex].indices {
                if cells[rowIndex][columnIndex].value == number {
                    cells[rowIndex][columnIndex].isMarked = true
                    break
                }
            }
        }
    }

    func myPrint() {
        for row in cells {
            for cell in row {
                print("\(cell.value)|\(cell.isMarked ? "T" : "F")", terminator: " ")
            }
            print()
        }
    }

    func hasWon() -> Bool {
        let hasWinningRow = cells.contains { $0.allSatisfy { $0.isMarked } }
        if hasWinningRow {
            return true
        }

        var hasWinningColumn = false
        for columnIndex in cells[0].indices {
            var columnSatisfies = true

            for rowIndex in cells.indices {
                if !cells[rowIndex][columnIndex].isMarked {
                    columnSatisfies = false
                    break
                }
            }

            if columnSatisfies {
                hasWinningColumn = columnSatisfies
                break
            }
        }

        return hasWinningColumn
    }

    func score(winningNumber: Int) -> Int {
        var sum = 0
        for row in cells {
            for cell in row {
                if !cell.isMarked {
                    sum += cell.value
                }
            }
        }
        return sum * winningNumber
    }
}

func parseInput(data: String) -> ([Int], [Board]) {
    let array = data.split(separator: "\n\n")

    let numbers = array[0]
        .components(separatedBy: ",")
        .compactMap(Int.init)

    let boards = array
        .dropFirst()
        .map {
            Board(data: $0
                .components(separatedBy: .newlines)
                .flatMap { $0
                    .components(separatedBy: " ")
                    .compactMap(Int.init)
                }
            )
        }

    return (numbers, boards)
}
