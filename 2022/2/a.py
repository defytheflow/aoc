POINTS = {
    "ROCK": 1,
    "PAPER": 2,
    "SCISSORS": 3,
    "DRAW": 3,
    "WIN": 6,
}

OPPONENT_ROCK, OPPONENT_PAPER, OPPONENT_SCISSORS = "ABC"
ME_ROCK, ME_PAPER, ME_SCISSORS = "XYZ"

with open("./input.txt") as f:
    total = 0
    for line in f:
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

        if ((opponent == OPPONENT_ROCK and me == ME_ROCK) or
            (opponent == OPPONENT_PAPER and me == ME_PAPER) or
            (opponent == OPPONENT_SCISSORS and me == ME_SCISSORS)):
            total += POINTS["DRAW"]

    print(total)
