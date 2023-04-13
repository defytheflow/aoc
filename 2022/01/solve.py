from functools import partial
from pathlib import Path


def main() -> None:
    data = (Path(__file__).parent / "input.txt").read_text().strip()

    result_one = solve_one(data)
    print(result_one)
    assert result_one == 70_509

    result_two = solve_two(data)
    print(result_two)
    assert result_two == 208_567


def solve(data: str, count: int) -> int:
    lines = sorted(sum(int(s) for s in line.split("\n")) for line in data.split("\n\n"))
    return sum(lines[-count:])


solve_one = partial(solve, count=1)
solve_two = partial(solve, count=3)


if __name__ == "__main__":
    main()
