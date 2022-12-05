OPPONENT = {
    "ROCK": "A",
    "PAPER": "B",
    "SCISSORS": "C",
}

POINTS = {
    "ROCK": 1,
    "PAPER": 2,
    "SCISSORS": 3,
    "DRAW": 3,
    "WIN": 6,
}


def part_1():
    ME_ROCK, ME_PAPER, ME_SCISSORS = "XYZ"

    with open("./input.txt") as f:
        total = 0
        for line in f:
            opponent, me = line.strip().split(" ")
            if me == ME_ROCK:
                total += POINTS["ROCK"]
                if opponent == OPPONENT["SCISSORS"]:
                    total += POINTS["WIN"]

            elif me == ME_PAPER:
                total += POINTS["PAPER"]
                if opponent == OPPONENT["ROCK"]:
                    total += POINTS["WIN"]

            elif me == ME_SCISSORS:
                total += POINTS["SCISSORS"]
                if opponent == OPPONENT["PAPER"]:
                    total += POINTS["WIN"]

            if (
                (opponent == OPPONENT["ROCK"] and me == ME_ROCK)
                or (opponent == OPPONENT["PAPER"] and me == ME_PAPER)
                or (opponent == OPPONENT["SCISSORS"] and me == ME_SCISSORS)
            ):
                total += POINTS["DRAW"]

        print(total)


def part_2():
    LOSS, DRAW, WIN = "XYZ"

    with open("./input.txt") as f:
        total = 0
        for line in f:
            opponent, me = line.strip().split(" ")
            if opponent == OPPONENT["ROCK"]:
                if me == WIN:
                    total += POINTS["PAPER"]
                    total += POINTS["WIN"]
                elif me == DRAW:
                    total += POINTS["ROCK"]
                    total += POINTS["DRAW"]
                elif me == LOSS:
                    total += POINTS["SCISSORS"]

            elif opponent == OPPONENT["PAPER"]:
                if me == WIN:
                    total += POINTS["SCISSORS"]
                    total += POINTS["WIN"]
                elif me == DRAW:
                    total += POINTS["PAPER"]
                    total += POINTS["DRAW"]
                elif me == LOSS:
                    total += POINTS["ROCK"]

            elif opponent == OPPONENT["SCISSORS"]:
                if me == WIN:
                    total += POINTS["ROCK"]
                    total += POINTS["WIN"]
                elif me == DRAW:
                    total += POINTS["SCISSORS"]
                    total += POINTS["DRAW"]
                elif me == LOSS:
                    total += POINTS["PAPER"]

        print(total)


part_1()
part_2()
