from pathlib import Path


def solve(data: str, count: int) -> int:
    lines = sorted(sum(map(int, line.split("\n"))) for line in data.split("\n\n"))
    return sum(lines[-count:])


def solve_one(data: str) -> int:
    return solve(data, 1)


def solve_two(data: str) -> int:
    return solve(data, 3)


if __name__ == "__main__":
    data = (Path(__file__).parent / "input.txt").read_text().strip()

    solution_one = solve_one(data)
    print(solution_one)
    assert solution_one == 70509

    solution_two = solve_two(data)
    print(solution_two)
    assert solution_two == 208567
