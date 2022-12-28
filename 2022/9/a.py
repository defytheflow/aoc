from dataclasses import dataclass
from pathlib import Path


@dataclass
class Point:
    x: int
    y: int


def are_touching(a: Point, b: Point) -> bool:
    return abs(a.x - b.x) <= 1 and abs(a.y - b.y) <= 1


direction_to_velocity = {"L": (-1, 0), "R": (1, 0), "U": (0, 1), "D": (0, -1)}

with open(Path(__file__).parent.joinpath("input.txt")) as f:
    head = Point(0, 0)
    tail = Point(0, 0)
    tail_visited = {(tail.x, tail.y)}

    for line in f:
        direction, count = line.rstrip("\n").split(" ")
        count = int(count)
        x, y = direction_to_velocity[direction]

        if direction == "L" or direction == "R":
            for _ in range(count):
                head.x += x
                if not are_touching(head, tail):
                    if head.x != tail.x and head.y != tail.y:
                        tail.y += 1 if tail.y < head.y else -1
                    tail.x += x
                tail_visited.add((tail.x, tail.y))

        elif direction == "U" or direction == "D":
            for _ in range(count):
                head.y += y
                if not are_touching(head, tail):
                    if head.x != tail.x and head.y != tail.y:
                        tail.x += 1 if tail.x < head.x else -1
                    tail.y += y
                tail_visited.add((tail.x, tail.y))

    result = len(tail_visited)
    print(result)
    assert result == 5683
