from pathlib import Path
from string import ascii_letters


def solve_one(data: str) -> int:
    total = 0
    lines = data.split("\n")

    for line in lines:
        half = len(line) // 2
        c1 = set(line[:half])
        c2 = set(line[half:])
        item = (c1 & c2).pop()
        total += ascii_letters.index(item) + 1

    return total


def solve_two(data: str) -> int:
    total = 0
    lines = data.split("\n")

    for i in range(0, len(lines), 3):
        first = set(lines[i])
        second = set(lines[i + 1])
        third = set(lines[i + 2])
        item = (first & second & third).pop()
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
