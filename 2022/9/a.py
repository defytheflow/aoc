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


with open(Path(__file__).parent.joinpath("input.txt")) as f:
    head = Point(0, 0)
    tail = Point(0, 0)
    unique_tail_points = {tail.as_tuple()}

    for line in f:
        direction, count = line.rstrip("\n").split(" ")
        count = int(count)

        if direction == "L":
            for i in range(count):
                head.x -= 1
                if not are_touching(head, tail):
                    if head.x != tail.x and head.y != tail.y:
                        tail.y += 1 if tail.y < head.y else -1
                    tail.x -= 1
                unique_tail_points.add(tail.as_tuple())

        elif direction == "R":
            for i in range(count):
                head.x += 1
                if not are_touching(head, tail):
                    if head.x != tail.x and head.y != tail.y:
                        tail.y += 1 if tail.y < head.y else -1
                    tail.x += 1
                unique_tail_points.add(tail.as_tuple())

        elif direction == "U":
            for i in range(count):
                head.y += 1
                if not are_touching(head, tail):
                    if head.x != tail.x and head.y != tail.y:
                        tail.x += 1 if tail.x < head.x else -1
                    tail.y += 1
                unique_tail_points.add(tail.as_tuple())

        elif direction == "D":
            for i in range(count):
                head.y -= 1
                if not are_touching(head, tail):
                    if head.x != tail.x and head.y != tail.y:
                        tail.x += 1 if tail.x < head.x else -1
                    tail.y -= 1
                unique_tail_points.add(tail.as_tuple())

    n_positions = len(unique_tail_points)
    assert n_positions == 5683
    print(n_positions)
