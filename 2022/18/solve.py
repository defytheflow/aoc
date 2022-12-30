from pathlib import Path
from typing import NamedTuple

Point = NamedTuple("Point", [("x", int), ("y", int), ("z", int)])


def solve_one(data: str) -> int:
    points: list[Point] = []

    for line in data.split("\n"):
        x, y, z = map(int, line.split(","))
        points.append(Point(x, y, z))

    total = 0

    for point_a in points:
        a_exposed_sides = 6

        for point_b in points:
            if point_a == point_b:
                continue

            if (
                point_a.x == point_b.x
                and point_a.y == point_b.y
                and abs(point_a.z - point_b.z) == 1
            ):
                a_exposed_sides -= 1

            if (
                point_a.x == point_b.x
                and point_a.z == point_b.z
                and abs(point_a.y - point_b.y) == 1
            ):
                a_exposed_sides -= 1

            if (
                point_a.y == point_b.y
                and point_a.z == point_b.z
                and abs(point_a.x - point_b.x) == 1
            ):
                a_exposed_sides -= 1

        total += a_exposed_sides

    return total


def solve_two(data: str) -> ...:
    ...


if __name__ == "__main__":
    data = (Path(__file__).parent / "input.txt").read_text().strip()

    solution_one = solve_one(data)
    print(solution_one)
    assert solution_one == 3448

    # solution_two = solve_two(data)
    # print(solution_two)
    # assert solution_two == ...
