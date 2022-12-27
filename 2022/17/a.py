from dataclasses import dataclass
from enum import Enum, auto
from itertools import cycle
from pathlib import Path
from typing import Literal


@dataclass
class Point:
    x: int
    y: int
    ch: Literal[".", "#"] = "."

    def is_empty(self) -> bool:
        return self.ch == "."


class RockType(Enum):
    HORIZONTAL = auto()
    PLUS = auto()
    L_SHAPE = auto()
    VERTICAL = auto()
    SQUARE = auto()


Grid = list[list[Point]]


@dataclass
class Rock:
    type: RockType
    points: list[Point]

    def __post_init__(self):
        for point in self.points:
            point.ch = "#"

    def get_height(self):
        ys: set[int] = set()
        for point in self.points:
            ys.add(point.y)
        return len(ys)

    def collides_left(self, grid: Grid) -> bool:
        if self.type == RockType.HORIZONTAL:
            left_most_point = min(self.points, key=lambda point: point.x)
            return (
                left_most_point.x == 0
                or not grid[left_most_point.y][left_most_point.x - 1].is_empty()
            )

        elif self.type == RockType.PLUS:
            left_most_point = min(self.points, key=lambda point: point.x)
            return left_most_point.x == 0 or not (
                grid[left_most_point.y][left_most_point.x - 1].is_empty()
                and grid[left_most_point.y + 1][left_most_point.x].is_empty()
                and grid[left_most_point.y - 1][left_most_point.x].is_empty()
            )

        elif self.type == RockType.L_SHAPE:
            top_most_point = max(self.points, key=lambda point: point.y)
            left_most_point = min(self.points, key=lambda point: point.x)
            right_most_point = max(self.points, key=lambda point: point.x)
            return left_most_point.x == 0 or not (
                grid[left_most_point.y][left_most_point.x - 1].is_empty()
                and grid[top_most_point.y][right_most_point.x - 1].is_empty()
                and grid[top_most_point.y - 1][right_most_point.x - 1].is_empty()
            )

        elif self.type == RockType.VERTICAL:
            left_most_point = min(self.points, key=lambda point: point.x)
            return left_most_point.x == 0 or not all(
                grid[point.y][left_most_point.x - 1].is_empty() for point in self.points
            )

        elif self.type == RockType.SQUARE:
            top_most_point = max(self.points, key=lambda point: point.y)
            left_most_point = min(self.points, key=lambda point: point.x)
            return left_most_point.x == 0 or not (
                grid[top_most_point.y][left_most_point.x - 1].is_empty()
                and grid[top_most_point.y - 1][left_most_point.x - 1].is_empty()
            )

        raise AssertionError("Unhandled type")

    def collides_right(self, grid: Grid) -> bool:
        if self.type == RockType.HORIZONTAL:
            right_most_point = max(self.points, key=lambda point: point.x)
            return right_most_point.x == len(grid[0]) - 1 or (
                not grid[right_most_point.y][right_most_point.x + 1].is_empty()
            )

        elif self.type == RockType.PLUS:
            right_most_point = max(self.points, key=lambda point: point.x)
            return right_most_point.x == len(grid[0]) - 1 or not (
                grid[right_most_point.y][right_most_point.x + 1].is_empty()
                and grid[right_most_point.y + 1][right_most_point.x].is_empty()
                and grid[right_most_point.y - 1][right_most_point.x].is_empty()
            )

        elif self.type == RockType.L_SHAPE:
            top_most_point = max(self.points, key=lambda point: point.y)
            right_most_point = max(self.points, key=lambda point: point.x)
            return right_most_point.x == len(grid[0]) - 1 or not (
                grid[top_most_point.y][right_most_point.x + 1].is_empty()
                and grid[top_most_point.y - 1][right_most_point.x + 1].is_empty()
                and grid[top_most_point.y - 2][right_most_point.x + 1].is_empty()
            )

        elif self.type == RockType.VERTICAL:
            right_most_point = max(self.points, key=lambda point: point.x)
            return right_most_point.x == len(grid[0]) - 1 or not all(
                grid[point.y][right_most_point.x + 1].is_empty()
                for point in self.points
            )

        elif self.type == RockType.SQUARE:
            top_most_point = max(self.points, key=lambda point: point.y)
            right_most_point = max(self.points, key=lambda point: point.x)
            return right_most_point.x == len(grid[0]) - 1 or not (
                grid[top_most_point.y][right_most_point.x + 1].is_empty()
                and grid[top_most_point.y - 1][right_most_point.x + 1].is_empty()
            )

        raise AssertionError("Unhandled type")

    def collides_down(self, grid: Grid) -> bool:
        if self.type == RockType.HORIZONTAL:
            bottom_most_point = min(self.points, key=lambda point: point.y)
            return bottom_most_point.y == 0 or not all(
                grid[bottom_most_point.y - 1][point.x].is_empty()
                for point in next_rock.points
            )

        elif self.type == RockType.PLUS:
            bottom_most_point = min(self.points, key=lambda point: point.y)
            return bottom_most_point.y == 0 or not (
                grid[bottom_most_point.y - 1][bottom_most_point.x].is_empty()
                and grid[bottom_most_point.y][bottom_most_point.x - 1].is_empty()
                and grid[bottom_most_point.y][bottom_most_point.x + 1].is_empty()
            )

        elif self.type == RockType.L_SHAPE:
            bottom_most_point = min(self.points, key=lambda point: point.y)
            return bottom_most_point.y == 0 or not all(
                grid[bottom_most_point.y - 1][point.x].is_empty()
                for point in next_rock.points
                if point.y == bottom_most_point.y
            )

        elif self.type == RockType.VERTICAL:
            bottom_most_point = min(self.points, key=lambda point: point.y)
            return (
                bottom_most_point.y == 0
                or not grid[bottom_most_point.y - 1][bottom_most_point.x].is_empty()
            )

        elif self.type == RockType.SQUARE:
            left_most_point = min(self.points, key=lambda point: point.x)
            bottom_most_point = min(self.points, key=lambda point: point.y)
            return bottom_most_point.y == 0 or not (
                grid[bottom_most_point.y - 1][left_most_point.x].is_empty()
                and grid[bottom_most_point.y - 1][left_most_point.x + 1].is_empty()
            )

        raise AssertionError("Unhandled type")


def print_grid(grid: list[list[Point]]) -> None:
    print()
    for _, row in enumerate(reversed(grid)):
        print("|", end="")
        for col in row:
            print(col.ch, end="")
        print("|")
    print("+-------+")


def create_horizontal(grid: Grid) -> Rock:
    return Rock(RockType.HORIZONTAL, [Point(x, len(grid) - 1) for x in range(2, 6)])


def create_plus(grid: Grid) -> Rock:
    return Rock(
        RockType.PLUS,
        [
            Point(3, len(grid) - 1),
            *[Point(x, len(grid) - 2) for x in range(2, 5)],
            Point(3, len(grid) - 3),
        ],
    )


def create_l_shape(grid: Grid) -> Rock:
    return Rock(
        RockType.L_SHAPE,
        [
            Point(4, len(grid) - 1),
            Point(4, len(grid) - 2),
            *[Point(x, len(grid) - 3) for x in range(2, 5)],
        ],
    )


def create_vertical(grid: Grid) -> Rock:
    return Rock(
        RockType.VERTICAL,
        [Point(2, y) for y in range(len(grid) - 1, len(grid) - 5, -1)],
    )


def create_square(grid: Grid) -> Rock:
    return Rock(
        RockType.SQUARE,
        [
            *[Point(x, len(grid) - 1) for x in range(2, 4)],
            *[Point(x, len(grid) - 2) for x in range(2, 4)],
        ],
    )


with open(Path(__file__).parent.joinpath("input.txt")) as f:
    grid: Grid = [[Point(x, y) for x in range(0, 7)] for y in range(3)]

    rock_factory_gen = cycle(
        [create_horizontal, create_plus, create_l_shape, create_vertical, create_square]
    )
    pattern_gen = cycle(f.read())
    n_rocks = 0

    while n_rocks < 2022:
        next_rock_factory = next(rock_factory_gen)
        next_rock = next_rock_factory(grid)
        n_rocks += 1

        # the bottom most point of shape should have a difference of three
        # with the top most floor

        # detect the height point
        # if the difference between the height point and grid's height is less than 3, than add
        # required rows
        grid_points = [point for row in grid for point in row if point.ch == "#"]
        top_most_point = max(grid_points, key=lambda point: point.y, default=None)
        shape_bottom_most_point = min(next_rock.points, key=lambda point: point.y)

        if top_most_point is None:
            top_most_point_y = 0
        else:
            top_most_point_y = top_most_point.y

        if top_most_point is None:
            adder = 0
        else:
            adder = 1

        diff = shape_bottom_most_point.y - top_most_point_y
        n_rows_to_append = 3 - diff + adder

        # if top_most_point is not None:
        #     n_rows_to_append = len(grid) - top_most_point.y + 1

        # Increase the grid size by next_rock's height - 1
        for _ in range(n_rows_to_append):
            grid.append([Point(x, len(grid)) for x in range(0, 7)])

        for point in next_rock.points:
            point.y += n_rows_to_append

        for point in next_rock.points:
            if point.y < len(grid):
                grid[point.y][point.x] = point

        while True:
            # print_grid(grid)

            next_pattern = next(pattern_gen)
            bottom_most_point = min(next_rock.points, key=lambda point: point.y)

            # Move the next_rock by pattern (TRICKY)
            if next_pattern == "<":
                if next_rock.collides_left(grid):
                    pass
                else:
                    for point in next_rock.points:
                        grid[point.y][point.x] = Point(point.x, point.y)

                    for point in next_rock.points:
                        point.x -= 1
                        grid[point.y][point.x] = point

            elif next_pattern == ">":
                if next_rock.collides_right(grid):
                    pass
                else:
                    for point in next_rock.points:
                        grid[point.y][point.x] = Point(point.x, point.y)

                    for point in next_rock.points:
                        point.x += 1
                        grid[point.y][point.x] = point

            # Detect collision
            if next_rock.collides_down(grid):
                break

            # print_grid(grid)
            # Move the next_rock down

            for point in next_rock.points:
                grid[point.y][point.x] = Point(point.x, point.y)

            for point in next_rock.points:
                point.y -= 1
                grid[point.y][point.x] = point

    grid_points = [point for row in grid for point in row if point.ch == "#"]
    # print(len(grid_points))
    # __import__("pprint").pprint(
    #     sorted(grid_points, reverse=True, key=lambda point: point.y)[:30]
    # )
    top_most_point = max(grid_points, key=lambda point: point.y, default=None)
    assert top_most_point is not None, "top_most_point is None"

    result = top_most_point.y + 1
    assert result == 3102
    print(result)
    # print(len(grid))
