from pathlib import Path
from string import ascii_letters
from typing import Iterable


def grouper(iterable: Iterable[str], n: int) -> Iterable[tuple[str, ...]]:
    args = [iter(iterable)] * n
    return zip(*args)


def solve_one(data: str) -> int:
    total = 0

    for line in data.split("\n"):
        half = len(line) // 2
        one = line[:half]
        two = line[half:]
        item = (set(one) & set(two)).pop()
        total += ascii_letters.index(item) + 1

    return total


def solve_two(data: str) -> int:
    total = 0

    for one, two, three in grouper(data.split("\n"), 3):
        item = (set(one) & set(two) & set(three)).pop()
        total += ascii_letters.index(item) + 1

    return total


if __name__ == "__main__":
    data = (Path(__file__).parent / "input.txt").read_text().strip()

    solution_one = solve_one(data)
    print(solution_one)
    assert solution_one == 7674

    solution_two = solve_two(data)
    print(solution_two)
    assert solution_two == 2805
