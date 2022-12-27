from pathlib import Path
from typing import NamedTuple

Point = NamedTuple("Point", [("x", int), ("y", int), ("z", int)])


with open(Path(__file__).parent.joinpath("input.txt")) as f:
    points: list[Point] = []

    for line in f:
        x, y, z = map(int, line.rstrip("\n").split(","))
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

    print(total)
    assert total == 3448
