from pathlib import Path


def solve_one(data: str) -> int:
    total = 0

    for line in data.split("\n"):
        s1, s2 = [[int(n) for n in s.split("-")] for s in line.strip().split(",")]
        (a1, b1), (a2, b2) = s1, s2
        if (a2 <= a1 and b1 <= b2) or (a1 <= a2 and b2 <= b1):
            total += 1

    return total


def solve_two(data: str) -> int:
    total = 0

    for line in data.split("\n"):
        s1, s2 = [[int(n) for n in s.split("-")] for s in line.strip().split(",")]
        (a1, b1), (a2, b2) = s1, s2
        if (a2 <= a1 <= b2) or (a2 <= b1 <= b2) or (a1 <= a2 <= b1) or (a1 <= b2 <= b1):
            total += 1

    return total


if __name__ == "__main__":
    data = (Path(__file__).parent / "input.txt").read_text().strip()

    solution_one = solve_one(data)
    print(solution_one)
    assert solution_one == 503

    solution_two = solve_two(data)
    print(solution_two)
    assert solution_two == 827
