from functools import partial
from pathlib import Path
from typing import Callable


def main() -> None:
    data = (Path(__file__).parent / "input.txt").read_text().strip()

    result_one = solve_one(data)
    print(result_one)
    assert result_one == 503

    result_two = solve_two(data)
    print(result_two)
    assert result_two == 827


Pair = tuple[int, int]


def solve(data: str, condition: Callable[[Pair, Pair], bool]) -> int:
    total = 0

    for line in data.split("\n"):
        s1, s2 = [tuple(int(n) for n in s.split("-")) for s in line.split(",")]
        if condition(s1, s2):
            total += 1

    return total


def contains(s1: Pair, s2: Pair) -> bool:
    (a1, b1), (a2, b2) = s1, s2
    return (a2 <= a1 and b1 <= b2) or (a1 <= a2 and b2 <= b1)


def overlap(s1: Pair, s2: Pair) -> bool:
    (a1, b1), (a2, b2) = s1, s2
    return (a2 <= a1 <= b2) or (a2 <= b1 <= b2) or (a1 <= a2 <= b1) or (a1 <= b2 <= b1)


solve_one = partial(solve, condition=contains)
solve_two = partial(solve, condition=overlap)


if __name__ == "__main__":
    main()
