from pathlib import Path


def solve(data: str, count: int) -> int:
    for i in range(count, len(data)):
        if len(set(data[i - count : i])) == count:
            return i
    raise AssertionError("This should never happen")


def solve_one(data: str) -> int:
    return solve(data, 4)


def solve_two(data: str) -> int:
    return solve(data, 14)


if __name__ == "__main__":
    data = (Path(__file__).parent / "input.txt").read_text().strip()

    solution_one = solve_one(data)
    print(solution_one)
    assert solution_one == 1623

    solution_two = solve_two(data)
    print(solution_two)
    assert solution_two == 3774
