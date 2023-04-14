import Foundation

let data = try String(contentsOfFile: "input.txt")

let result_one = solve_one(data: data)
print(result_one!)
assert(result_one == 72_770)

let result_two = solve_two(data: data)
print(result_two!)
assert(result_two == 13_912)

func solve_one(data: String) -> Int? {
    var (numbers, boards) = parse_input(data: data)

    for number in numbers {
        for i in boards.indices {
            boards[i].mark(number)
            if boards[i].hasWon() {
                return boards[i].score(winningNumber: number)
            }
        }
    }

    return nil
}

func solve_two(data: String) -> Int? {
    var (numbers, boards) = parse_input(data: data)
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

    return nil
}

struct Board {
    struct Cell {
        let value: Int
        var isMarked = false
    }

    private var cells: [[Cell]]

    init(data: [Int]) {
        cells = []

        var row: [Cell] = []
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
        let hasWinningRow = cells.contains { $0.allSatisfy({ $0.isMarked }) }
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

func parse_input(data: String) -> ([Int], [Board]) {
    let array = data.split(separator: "\n\n")
    let numbers = array[0].split(separator: ",").map { Int($0)! }
    let boards = array[1..<array.count]
        .map({
            Board(data: $0
              .split(separator: "\n")
              .flatMap({ $0.split(separator: " ").map({ Int($0)! }) }))
        })
    return (numbers, boards)
}
