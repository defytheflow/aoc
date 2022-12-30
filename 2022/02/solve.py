from pathlib import Path
from typing import Literal

Shape = Literal["R", "P", "S"]
Round = tuple[Shape, Shape]

shape_map: dict[str, Shape] = {
    "X": "R",
    "Y": "P",
    "Z": "S",
    "A": "R",
    "B": "P",
    "C": "S",
}

wins: list[Round] = [("R", "S"), ("S", "P"), ("P", "R")]


def solve(rounds: list[Round]) -> int:
    score_map: dict[Shape, int] = {"R": 1, "P": 2, "S": 3}
    win_score = 6
    draw_score = 3
    total = 0

    for op, me in rounds:
        total += score_map[me]
        if op == me:
            total += draw_score
        elif (me, op) in wins:
            total += win_score

    return total


def solve_one(data: str) -> int:
    rounds: list[Round] = [
        tuple(shape_map[s] for s in line.split(" ")) for line in data.split("\n")
    ]
    return solve(rounds)


def solve_two(data: str) -> int:
    round_end_map = {"X": "loss", "Y": "draw", "Z": "win"}
    rounds: list[Round] = []

    for line in data.split("\n"):
        op, end = line.split(" ")
        op = shape_map[op]
        end = round_end_map[end]

        if end == "draw":
            me = op
        elif end == "win":
            me = next((win[0] for win in wins if win[1] == op))
        elif end == "loss":
            me = next((win[1] for win in wins if win[0] == op))
        else:
            raise AssertionError("This should never happen")

        rounds.append((op, me))

    return solve(rounds)


if __name__ == "__main__":
    data = (Path(__file__).parent / "input.txt").read_text().strip()

    solution_one = solve_one(data)
    print(solution_one)
    assert solution_one == 15_523

    solution_two = solve_two(data)
    print(solution_two)
    assert solution_two == 15_702
