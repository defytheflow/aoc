import Foundation

let data = try String(contentsOfFile: "input.txt")

let result_one = solve_one(data: data)
print(result_one)
assert(result_one == 8111)

let result_two = solve_two(data: data)
print(result_two)
assert(result_two == 22088)

func solve_one(data: String) -> Int {
    solve(lines: parse_input(data: data)
                    .filter { $0.start.x == $0.end.x || $0.start.y == $0.end.y })
}

func solve_two(data: String) -> Int {
    solve(lines: parse_input(data: data))
}

func solve(lines: [Line]) -> Int {
    var points: [Point: Int] = [:]

    for line in lines {
        for point in line.points() {
            points[point] = (points[point] ?? 0) + 1
        }
    }

    return points.reduce(0) { (total, entry) in entry.value > 1 ? total + 1 : total }
}

struct Line {
    let start, end: Point

    func points() -> [Point] {
        var points: [Point] = []

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

func parse_input(data: String) -> [Line] {
    data
        .split(separator: "\n")
        .map { line in
            let points = line
                .split(separator: " -> ")
                .map { point in
                    let coords = point
                        .split(separator: ",")
                        .map { Int($0)! }
                    return Point(x: coords[0], y: coords[1])
                }
            return Line(start: points[0], end: points[1])
        }
}
