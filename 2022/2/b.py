from pathlib import Path

POINTS = {
    "ROCK": 1,
    "PAPER": 2,
    "SCISSORS": 3,
    "DRAW": 3,
    "WIN": 6,
}

OPPONENT_ROCK, OPPONENT_PAPER, OPPONENT_SCISSORS = "ABC"
LOSS, DRAW, WIN = "XYZ"

with open(Path(__file__).parent.joinpath("input.txt")) as f:
    total = 0

    for line in f:
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

    assert total == 15702
    print(total)
