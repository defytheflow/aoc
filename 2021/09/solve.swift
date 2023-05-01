import Foundation

main()

func main() {
    let input = parseInput(data: try! String(contentsOfFile: "input.txt"))

    let resultOne = solveOne(input: input)
    print(resultOne)
    assert(resultOne == 468)

    let resultTwo = solveTwo(input: input)
    print(resultTwo)
    assert(resultTwo == 1_280_496)
}

func solveOne(input matrix: [[Int]]) -> Int {
    findLowestPoints(in: matrix)
        .map { matrix[$0.y][$0.x] + 1 }
        .reduce(0, +)
}

func solveTwo(input matrix: [[Int]]) -> Int {
    var seen = Set<Point>()
    return findLowestPoints(in: matrix)
        .map { point in getBasinSize(from: point, matrix: matrix, seen: &seen) }
        .sorted()
        .suffix(3)
        .reduce(1, *)
}

func findLowestPoints(in matrix: [[Int]]) -> [Point] {
    var lowestPoints = [Point]()

    for (i, row) in matrix.enumerated() {
        for (j, height) in row.enumerated() {
            var adjacentHeights = [Int]()

            for (dx, dy) in [(-1, 0), (1, 0), (0, -1), (0, 1)] {
                let nextX = j + dx
                let nextY = i + dy

                if 0 <= nextX && nextX < matrix[0].count, 0 <= nextY && nextY < matrix.count {
                    adjacentHeights.append(matrix[nextY][nextX])
                }
            }

            if adjacentHeights.allSatisfy({ height < $0 }) {
                lowestPoints.append(Point(x: j, y: i))
            }
        }
    }

    return lowestPoints
}

func getBasinSize(from point: Point, matrix: [[Int]], seen: inout Set<Point>) -> Int {
    var size = 0

    if seen.contains(point) || matrix[point.y][point.x] == 9 {
        return size
    }

    size += 1
    seen.insert(point)

    for (dx, dy) in [(-1, 0), (1, 0), (0, -1), (0, 1)] {
        let nextX = point.x + dx
        let nextY = point.y + dy

        if 0 <= nextX && nextX < matrix[0].count, 0 <= nextY && nextY < matrix.count {
            size += getBasinSize(from: Point(x: nextX, y: nextY), matrix: matrix, seen: &seen)
        }
    }

    return size
}

struct Point: Hashable {
    let x, y: Int
}

func parseInput(data: String) -> [[Int]] {
    data
        .trimmingCharacters(in: .newlines)
        .components(separatedBy: .newlines)
        .map { row in
            row
                .split(separator: "")
                .compactMap { Int($0) }

        }
}
