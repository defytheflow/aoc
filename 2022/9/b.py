from dataclasses import dataclass
from pathlib import Path


@dataclass
class Point:
    x: int
    y: int

    def as_tuple(self) -> tuple[int, int]:
        return self.x, self.y


def are_touching(point_a: Point, point_b: Point) -> bool:
    return (
        # overlap
        point_a == point_b
        # adjacent row
        or (point_a.x == point_b.x and abs(point_a.y - point_b.y) == 1)
        # adjacent col
        or (point_a.y == point_b.y and abs(point_a.x - point_b.x) == 1)
        # adjacent diagonal
        or (abs(point_a.x - point_b.x) == 1 and abs(point_a.y - point_b.y) == 1)
    )


def move_points(points: list[Point]) -> None:
    head, *rest = points
    leading = head

    for point in rest:
        if not are_touching(leading, point):
            if leading.x != point.x:
                point.x += 1 if leading.x > point.x else -1

            if leading.y != point.y:
                point.y += 1 if leading.y > point.y else -1

        leading = point


def print_step(direction: str, count: int) -> None:
    print(f"\n== {direction} {count} ==\n")


def print_small_grid(points: list[Point]) -> None:
    for y in range(4, -1, -1):
        for x in range(5):
            for i, point in enumerate(points):
                if point.x == x and point.y == y:
                    char = "H" if i == 0 else str(i)
                    print(char, end="")
                    break
            else:
                print(".", end="")
        print()


def print_big_grid(points: list[Point]) -> None:
    for y in range(15, -6, -1):
        for x in range(-11, 15, 1):
            for i, point in enumerate(points):
                if point.x == x and point.y == y:
                    char = "H" if i == 0 else str(i)
                    print(char, end="")
                    break
            else:
                print(".", end="")
        print()


with open(Path(__file__).parent.joinpath("input.txt")) as f:
    points = [Point(0, 0) for _ in range(10)]
    unique_tail_points = {points[-1].as_tuple()}

    for line in f:
        direction, count = line.rstrip("\n").split(" ")
        count = int(count)
        head, *_, tail = points

        if direction == "L":
            for _ in range(count):
                head.x -= 1
                move_points(points)
                unique_tail_points.add(tail.as_tuple())

        elif direction == "R":
            for _ in range(count):
                head.x += 1
                move_points(points)
                unique_tail_points.add(tail.as_tuple())

        elif direction == "U":
            for _ in range(count):
                head.y += 1
                move_points(points)
                unique_tail_points.add(tail.as_tuple())

        elif direction == "D":
            for _ in range(count):
                head.y -= 1
                move_points(points)
                unique_tail_points.add(tail.as_tuple())

    print(len(unique_tail_points))
