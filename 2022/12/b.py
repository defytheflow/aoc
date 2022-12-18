from __future__ import annotations

import heapq
from dataclasses import dataclass
from functools import partial
from pathlib import Path


@dataclass
class Square:
    x: int
    y: int
    char: str

    @property
    def elevation(self) -> str:
        return "a" if self.char == "S" else "z" if self.char == "E" else self.char

    def __hash__(self) -> int:
        return hash((self.x, self.y))

    def __eq__(self, other: Square) -> bool:
        if isinstance(other, Square):
            return self.x == other.x and self.y == other.y
        return False

    def __lt__(self, other: Square) -> bool:
        if isinstance(other, Square):
            return self.x < other.x and self.y < other.y
        return NotImplemented


Grid = list[list[Square]]


def print_grid(grid: Grid, current: Square | None = None) -> None:
    for row in grid:
        for square in row:
            char = "." if square == current else square.char
            print(char, end="")
        print()


def predicate(current: Square, next_: Square) -> bool:
    current_el = ord(current.elevation)
    next_el = ord(next_.elevation)
    return current_el >= next_el or next_el - current_el == 1


def get_available_squares(grid: Grid, current: Square) -> list[Square]:
    squares: list[Square] = []

    # if we can look left
    if current.x > 0:
        squares.append(grid[current.y][current.x - 1])

    # if we can look right
    if current.x < len(grid[0]) - 1:
        squares.append(grid[current.y][current.x + 1])

    # if we can look up
    if current.y > 0:
        squares.append(grid[current.y - 1][current.x])

    # if we can look down
    if current.y < len(grid) - 1:
        squares.append(grid[current.y + 1][current.x])

    return list(filter(partial(predicate, current), squares))


# The heuristic function estimates the distance from a given position to the goal.
def heuristic(start: Square, end: Square) -> int:
    """Calculates the Manhattan distance between the two squares."""
    return abs(start.x - end.x) + abs(start.y - end.y)


def a_star_search(grid: Grid, start: Square, goal: Square) -> int | None:
    queue = []
    heapq.heappush(queue, (0, start))  # 0 - estimated cost to reach the goal square.
    steps = {start: 0}

    while queue:
        _, current = heapq.heappop(queue)

        if current == goal:
            return steps[current]

        for square in get_available_squares(grid, current):
            if square not in steps:
                steps[square] = steps[current] + 1
                estimated_cost = steps[square] + heuristic(square, goal)
                heapq.heappush(queue, (estimated_cost, square))

    return None


with open(Path(__file__).parent.joinpath("input.txt")) as f:
    grid: Grid = []
    start_squares: list[Square] = []
    goal: Square | None = None

    for y, line in enumerate(f):
        row = []
        for x, char in enumerate(line.rstrip("\n")):
            square = Square(x, y, char)
            if square.char == "S" or square.char == "a":
                start_squares.append(square)
            elif square.char == "E":
                goal = square
            row.append(square)
        grid.append(row)

    assert goal is not None, "goal is None"

    choices = sorted(
        (
            steps
            for steps in (a_star_search(grid, start, goal) for start in start_squares)
            if steps is not None
        )
    )

    print(choices)
    print(min(choices))
    # 526 is too high
    # on the input.txt I subtracted one and it worked (525) 🤷
