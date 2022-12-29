from pathlib import Path

POINTS = {
    "ROCK": 1,
    "PAPER": 2,
    "SCISSORS": 3,
    "DRAW": 3,
    "WIN": 6,
}


def solve_one(data: str) -> int:
    OPPONENT_ROCK, OPPONENT_PAPER, OPPONENT_SCISSORS = "ABC"
    ME_ROCK, ME_PAPER, ME_SCISSORS = "XYZ"

    total = 0

    for line in data.split("\n"):
        opponent, me = line.strip().split(" ")
        if me == ME_ROCK:
            total += POINTS["ROCK"]
            if opponent == OPPONENT_SCISSORS:
                total += POINTS["WIN"]

        elif me == ME_PAPER:
            total += POINTS["PAPER"]
            if opponent == OPPONENT_ROCK:
                total += POINTS["WIN"]

        elif me == ME_SCISSORS:
            total += POINTS["SCISSORS"]
            if opponent == OPPONENT_PAPER:
                total += POINTS["WIN"]

        if (
            (opponent == OPPONENT_ROCK and me == ME_ROCK)
            or (opponent == OPPONENT_PAPER and me == ME_PAPER)
            or (opponent == OPPONENT_SCISSORS and me == ME_SCISSORS)
        ):
            total += POINTS["DRAW"]

    return total


def solve_two(data: str) -> int:
    OPPONENT_ROCK, OPPONENT_PAPER, OPPONENT_SCISSORS = "ABC"
    LOSS, DRAW, WIN = "XYZ"

    total = 0

    for line in data.split("\n"):
        opponent, me = line.strip().split(" ")
        if opponent == OPPONENT_ROCK:
            if me == WIN:
                total += POINTS["PAPER"]
                total += POINTS["WIN"]
            elif me == DRAW:
                total += POINTS["ROCK"]
                total += POINTS["DRAW"]
            elif me == LOSS:
                total += POINTS["SCISSORS"]

        elif opponent == OPPONENT_PAPER:
            if me == WIN:
                total += POINTS["SCISSORS"]
                total += POINTS["WIN"]
            elif me == DRAW:
                total += POINTS["PAPER"]
                total += POINTS["DRAW"]
            elif me == LOSS:
                total += POINTS["ROCK"]

        elif opponent == OPPONENT_SCISSORS:
            if me == WIN:
                total += POINTS["ROCK"]
                total += POINTS["WIN"]
            elif me == DRAW:
                total += POINTS["SCISSORS"]
                total += POINTS["DRAW"]
            elif me == LOSS:
                total += POINTS["PAPER"]

    return total


if __name__ == "__main__":
    data = (Path(__file__).parent / "input.txt").read_text().strip()

    solution_one = solve_one(data)
    print(solution_one)
    assert solution_one == 15523

    solution_two = solve_two(data)
    print(solution_two)
    assert solution_two == 15702
