from pathlib import Path

with open(Path(__file__).parent.joinpath("input.txt")) as f:
    y = 2_000_000
    xs: set[int] = set()

    for line in f:
        line = line.rstrip("\n")
        sx, sy = [
            int(s[2:]) for s in line[line.index("x") : line.index(":")].split(", ")
        ]
        bx, by = [int(s[2:]) for s in line[line.rindex("x") :].split(", ")]
        dist = abs(sx - bx) + abs(sy - by)

        for x in range(sx - dist, sx + dist + 1):
            if abs(sx - x) + abs(sy - y) <= dist:
                xs.add(x)

    n_positions = len(xs) - 1  # minus the beacon position
    print(n_positions)
    assert n_positions == 4907780
