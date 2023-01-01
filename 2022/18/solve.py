from pathlib import Path
from typing import NamedTuple

Point = NamedTuple("Point", [("x", int), ("y", int), ("z", int)])


def solve_one(data: str) -> int:
    points = [Point(*(int(n) for n in line.split(","))) for line in data.split("\n")]
    total = 0

    for a in points:
        a_exposed_sides = 6
        for b in points:
            if a == b:
                continue
            if a.x == b.x and a.y == b.y and abs(a.z - b.z) == 1:
                a_exposed_sides -= 1
            if a.x == b.x and a.z == b.z and abs(a.y - b.y) == 1:
                a_exposed_sides -= 1
            if a.y == b.y and a.z == b.z and abs(a.x - b.x) == 1:
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
