import Foundation

main()

func main() {
    let inputFileURL = URL(fileURLWithPath: #file)
        .deletingLastPathComponent()
        .appendingPathComponent("input.txt")
    let input = parseInput(data: try! String(contentsOf: inputFileURL))

    let resultOne = solveOne(input: input)
    print(resultOne)
    assert(resultOne == 8_111)

    let resultTwo = solveTwo(input: input)
    print(resultTwo)
    assert(resultTwo == 22_088)
}

func solveOne(input: [Line]) -> Int {
    solve(input: input.filter { $0.start.x == $0.end.x || $0.start.y == $0.end.y })
}

func solveTwo(input: [Line]) -> Int {
    solve(input: input)
}

func solve(input: [Line]) -> Int {
    var points = [Point: Int]()

    for line in input {
        for point in line.points() {
            points[point, default: 0] += 1
        }
    }

    return points.filter { $0.value > 1 }.count
}

struct Line {
    let start, end: Point

    func points() -> [Point] {
        var points = [Point]()

        if self.start.x == self.end.x {
            let yStep = self.start.y < self.end.y ? 1 : -1
            for y in stride(from: self.start.y, to: self.end.y + yStep, by: yStep) {
                points.append(Point(x: self.start.x, y: y))
            }
        } else if self.start.y == self.end.y {
            let xStep = self.start.x < self.end.x ? 1 : -1
            for x in stride(from: self.start.x, to: self.end.x + xStep, by: xStep){
                points.append(Point(x: x, y: self.start.y))
            }
        } else {
            let xStep = self.start.x < self.end.x ? 1 : -1
            let yStep = self.start.y < self.end.y ? 1 : -1
            for (x, y) in zip(
                stride(from: self.start.x, to: self.end.x + xStep, by: xStep),
                stride(from: self.start.y, to: self.end.y + yStep, by: yStep)
            ) {
                points.append(Point(x: x, y: y))
            }
        }

        return points
    }
}

struct Point: Hashable {
    let x, y: Int
}

func parseInput(data: String) -> [Line] {
    data
        .trimmingCharacters(in: .newlines)
        .components(separatedBy: .newlines)
        .map { line in
            let points = line
                .split(separator: " -> ")
                .map { point in
                    let coords = point
                        .components(separatedBy: ",")
                        .compactMap(Int.init)
                    return Point(x: coords[0], y: coords[1])
                }
            return Line(start: points[0], end: points[1])
        }
}
