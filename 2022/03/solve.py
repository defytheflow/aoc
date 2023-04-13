from pathlib import Path
from string import ascii_letters
from typing import Iterable


def main() -> None:
    data = (Path(__file__).parent / "input.txt").read_text().strip()

    result_one = solve_one(data)
    print(result_one)
    assert result_one == 7674

    result_two = solve_two(data)
    print(result_two)
    assert result_two == 2805


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

    def grouper(iterable: Iterable[str], n: int) -> Iterable[tuple[str, ...]]:
        args = [iter(iterable)] * n
        return zip(*args)

    for one, two, three in grouper(data.split("\n"), 3):
        item = (set(one) & set(two) & set(three)).pop()
        total += ascii_letters.index(item) + 1

    return total


if __name__ == "__main__":
    main()
