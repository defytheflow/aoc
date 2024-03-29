from __future__ import annotations
from dataclasses import dataclass
from pathlib import Path


def main() -> None:
    data = (Path(__file__).parent / "input.txt").read_text().strip()

    result_one = solve_one(data)
    print(result_one)
    assert result_one == 5683

    result_two = solve_two(data)
    print(result_two)
    assert result_two == 2372


@dataclass
class Point:
    x: int
    y: int

    def touches(self, other: Point) -> bool:
        return abs(self.x - other.x) <= 1 and abs(self.y - other.y) <= 1


direction_to_velocity = {
    "L": (-1, 0),
    "R": (1, 0),
    "U": (0, 1),
    "D": (0, -1),
}


def solve_one(data: str) -> int:
    head = Point(0, 0)
    tail = Point(0, 0)
    tail_visited = {(tail.x, tail.y)}

    for line in data.split("\n"):
        direction, count = line.split(" ")
        count = int(count)
        x, y = direction_to_velocity[direction]

        if direction == "L" or direction == "R":
            for _ in range(count):
                head.x += x
                if not head.touches(tail):
                    if head.x != tail.x and head.y != tail.y:
                        tail.y += 1 if tail.y < head.y else -1
                    tail.x += x
                tail_visited.add((tail.x, tail.y))

        elif direction == "U" or direction == "D":
            for _ in range(count):
                head.y += y
                if not head.touches(tail):
                    if head.x != tail.x and head.y != tail.y:
                        tail.x += 1 if tail.x < head.x else -1
                    tail.y += y
                tail_visited.add((tail.x, tail.y))

    return len(tail_visited)


def solve_two(data: str) -> int:
    points = [Point(0, 0) for _ in range(10)]
    head, *rest = points
    tail = rest[-1]
    tail_visited = {(tail.x, tail.y)}

    for line in data.split("\n"):
        direction, count = line.split(" ")
        for _ in range(int(count)):
            x, y = direction_to_velocity[direction]
            head.x += x
            head.y += y

            leading = head
            for point in rest:
                if not leading.touches(point):
                    if leading.x != point.x:
                        point.x += 1 if leading.x > point.x else -1
                    if leading.y != point.y:
                        point.y += 1 if leading.y > point.y else -1
                leading = point

            tail_visited.add((tail.x, tail.y))

    return len(tail_visited)


if __name__ == "__main__":
    main()


# def print_step(direction: str, count: int) -> None:
#     print(f"\n== {direction} {count} ==\n")


# def print_small_grid(points: list[Point]) -> None:
#     for y in range(4, -1, -1):
#         for x in range(5):
#             for i, point in enumerate(points):
#                 if point.x == x and point.y == y:
#                     char = "H" if i == 0 else str(i)
#                     print(char, end="")
#                     break
#             else:
#                 print(".", end="")
#         print()


# def print_big_grid(points: list[Point]) -> None:
#     for y in range(15, -6, -1):
#         for x in range(-11, 15, 1):
#             for i, point in enumerate(points):
#                 if point.x == x and point.y == y:
#                     char = "H" if i == 0 else str(i)
#                     print(char, end="")
#                     break
#             else:
#                 print(".", end="")
#         print()
