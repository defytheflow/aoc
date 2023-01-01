from functools import partial
from pathlib import Path
from typing import Callable

Pair = tuple[int, int]


def contains(s1: Pair, s2: Pair) -> bool:
    (a1, b1), (a2, b2) = s1, s2
    return (a2 <= a1 and b1 <= b2) or (a1 <= a2 and b2 <= b1)


def overlap(s1: Pair, s2: Pair) -> bool:
    (a1, b1), (a2, b2) = s1, s2
    return (a2 <= a1 <= b2) or (a2 <= b1 <= b2) or (a1 <= a2 <= b1) or (a1 <= b2 <= b1)


def solve(data: str, condition: Callable[[Pair, Pair], bool]) -> int:
    total = 0

    for line in data.split("\n"):
        s1, s2 = [tuple(int(n) for n in s.split("-")) for s in line.split(",")]
        if condition(s1, s2):
            total += 1

    return total


solve_one = partial(solve, condition=contains)
solve_two = partial(solve, condition=overlap)


if __name__ == "__main__":
    data = (Path(__file__).parent / "input.txt").read_text().strip()

    solution_one = solve_one(data)
    print(solution_one)
    assert solution_one == 503

    solution_two = solve_two(data)
    print(solution_two)
    assert solution_two == 827
