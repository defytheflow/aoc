from collections import deque
from pathlib import Path
from typing import NamedTuple


def main() -> None:
    data = (Path(__file__).parent / "input.txt").read_text().strip()

    result_one = solve_one(data)
    print(result_one)
    assert result_one == 534

    result_two = solve_two(data)
    print(result_two)
    assert result_two == 525


Point = NamedTuple("Point", [("x", int), ("y", int)])


def solve_one(data: str) -> int:
    grid = [list(row) for row in data.split("\n")]
    start = Point(0, 0)
    end = Point(0, 0)

    for y, row in enumerate(grid):
        for x, tile in enumerate(row):
            if tile == "S":
                start = Point(x, y)
                row[x] = "a"
            elif tile == "E":
                end = Point(x, y)
                row[x] = "z"

    return bfs(grid, start, end)


def solve_two(data: str) -> int:
    grid = [list(row) for row in data.split("\n")]
    start_points: list[Point] = []
    end = Point(0, 0)

    for y, row in enumerate(grid):
        for x, tile in enumerate(row):
            if tile == "S" or tile == "a":
                start_points.append(Point(x, y))
                row[x] = "a"
            elif tile == "E":
                end = Point(x, y)
                row[x] = "z"

    return sorted(
        cost for cost in (bfs(grid, start, end) for start in start_points) if cost != -1
    )[0]


def bfs(grid: list[list[str]], start: Point, end: Point) -> int:
    queue: deque[tuple[Point, int]] = deque([(start, 0)])
    visited: set[Point] = set()

    while queue:
        point, cost = queue.popleft()
        if point == end:
            return cost

        if point in visited:
            continue
        visited.add(point)

        for neighbor in get_neighbors(grid, point):
            if neighbor not in visited:
                queue.append((neighbor, cost + 1))

    return -1


def get_neighbors(grid: list[list[str]], current: Point) -> list[Point]:
    points: list[Point] = []
    current_elevation = ord(grid[current.y][current.x])

    for x, y in [
        (current.x - 1, current.y),
        (current.x + 1, current.y),
        (current.x, current.y - 1),
        (current.x, current.y + 1),
    ]:
        if (0 <= x <= len(grid[0]) - 1) and (0 <= y <= len(grid) - 1):
            elevation = ord(grid[y][x])
            if current_elevation >= elevation or elevation - current_elevation == 1:
                points.append(Point(x, y))

    return points


if __name__ == "__main__":
    main()
