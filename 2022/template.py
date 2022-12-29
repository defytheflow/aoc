from pathlib import Path


def solve_one(data: str) -> ...:
    ...


def solve_two(data: str) -> ...:
    ...


if __name__ == "__main__":
    data = (Path(__file__).parent / "input.txt").read_text().strip()

    solution_one = solve_one(data)
    print(solution_one)
    assert solution_one == ...

    solution_two = solve_two(data)
    print(solution_two)
    assert solution_two == ...
