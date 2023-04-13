from functools import partial
from pathlib import Path


def main() -> None:
    data = (Path(__file__).parent / "input.txt").read_text().strip()

    result_one = solve_one(data)
    print(result_one)
    assert result_one == 1623

    result_two = solve_two(data)
    print(result_two)
    assert result_two == 3774


def solve(data: str, count: int) -> int:
    for i in range(count, len(data)):
        if len(set(data[i - count : i])) == count:
            return i
    assert False


solve_one = partial(solve, count=4)
solve_two = partial(solve, count=14)


if __name__ == "__main__":
    main()
