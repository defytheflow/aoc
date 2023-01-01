from functools import partial
from pathlib import Path


def solve(data: str, count: int) -> int:
    lines = sorted(sum(int(s) for s in line.split("\n")) for line in data.split("\n\n"))
    return sum(lines[-count:])


solve_one = partial(solve, count=1)
solve_two = partial(solve, count=3)


if __name__ == "__main__":
    data = (Path(__file__).parent / "input.txt").read_text().strip()

    solution_one = solve_one(data)
    print(solution_one)
    assert solution_one == 70_509

    solution_two = solve_two(data)
    print(solution_two)
    assert solution_two == 208_567
