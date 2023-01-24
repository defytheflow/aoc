from functools import partial
from pathlib import Path


def solve(data: str, count: int) -> int:
    for i in range(count, len(data)):
        if len(set(data[i - count : i])) == count:
            return i
    assert False


solve_one = partial(solve, count=4)
solve_two = partial(solve, count=14)


if __name__ == "__main__":
    data = (Path(__file__).parent / "input.txt").read_text().strip()

    solution_one = solve_one(data)
    print(solution_one)
    assert solution_one == 1623

    solution_two = solve_two(data)
    print(solution_two)
    assert solution_two == 3774
