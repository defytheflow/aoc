from dataclasses import dataclass
from pathlib import Path
from typing import Literal


@dataclass
class Point:
    x: int
    y: int
    ch: Literal[".", "#", "o"] = "."


Grid = list[list[Point]]


def print_grid(grid: Grid, start_x: int = 0) -> None:
    end_x = len(grid[0]) - 1
    xs = [
        str(x if x in (start_x, 500, end_x) else "").rjust(len(str(end_x)))
        for x in range(start_x, end_x + 1)
    ]

    for tup in zip(*xs):
        print("  ", end="")
        for ch in tup:
            print(ch, end="")
        print()

    for y, row in enumerate(grid):
        print(f"{y} ", end="")
        for point in row:
            if point.x >= start_x:
                print(point.ch, end="")
        print()


with open(Path(__file__).parent.joinpath("input.txt")) as f:
    max_x = 0
    min_x = float("inf")
    max_y = 0
    paths: list[list[Point]] = []

    for line in f:
        path = [
            Point(int(x), int(y), ch=".")
            for x, y in [point.split(",") for point in line.rstrip("\n").split(" -> ")]
        ]
        for next_ in path:
            if next_.x > max_x:
                max_x = next_.x

            if next_.x < min_x:
                min_x = next_.x

            if next_.y > max_y:
                max_y = next_.y
        paths.append(path)

    grid = [[Point(x, y) for x in range(max_x + 1)] for y in range(max_y + 1)]

    for first, *rest in paths:
        grid[first.y][first.x].ch = "#"
        prev = first

        for next_ in rest:
            if next_.x == prev.x:
                diff_y = next_.y - prev.y
                step = 1 if diff_y > 0 else -1
                for y in range(prev.y + step, prev.y + diff_y + step, step):
                    grid[y][next_.x].ch = "#"

            elif next_.y == prev.y:
                diff_x = next_.x - prev.x
                step = 1 if diff_x > 0 else -1
                for x in range(prev.x + step, prev.x + diff_x + step, step):
                    grid[next_.y][x].ch = "#"

            prev = next_

    n_units = 0
    while True:
        sand = Point(500, 0, ch="o")
        try:
            while True:
                next_row = grid[sand.y + 1]
                if next_row[sand.x].ch == ".":
                    sand.y += 1
                elif next_row[sand.x - 1].ch == ".":
                    sand.x -= 1
                    sand.y += 1
                elif next_row[sand.x + 1].ch == ".":
                    sand.x += 1
                    sand.y += 1
                else:
                    break
        except IndexError:
            break
        grid[sand.y][sand.x].ch = "o"
        n_units += 1

    print(n_units)
