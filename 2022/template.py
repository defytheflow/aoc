from pathlib import Path


def main() -> None:
    data = (Path(__file__).parent / "input.txt").read_text().strip()

    result_one = solve_one(data)
    print(result_one)
    assert result_one == ...

    result_two = solve_two(data)
    print(result_two)
    assert result_two == ...


def solve_one(data: str) -> ...:
    ...


def solve_two(data: str) -> ...:
    ...


if __name__ == "__main__":
    main()
