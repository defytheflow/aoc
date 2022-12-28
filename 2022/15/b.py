from pathlib import Path

with open(Path(__file__).parent.joinpath("input.txt")) as f:
    entries: list[tuple[int, int, int]] = []

    for line in f:
        line = line.rstrip("\n")
        sx, sy = [
            int(s[2:]) for s in line[line.index("x") : line.index(":")].split(", ")
        ]
        bx, by = [int(s[2:]) for s in line[line.rindex("x") :].split(", ")]
        dist = abs(sx - bx) + abs(sy - by)
        entries.append((sx, sy, dist))

    for sx, sy, dist in entries:
        # Check all points that are dist+1 away from (sx,sy)
        for dx in range(dist + 2):
            dy = dist + 1 - dx
            for sign_x, sign_y in [(-1, -1), (-1, 1), (1, -1), (1, 1)]:
                x = sx + dx * sign_x
                y = sy + dy * sign_y
                if (
                    0 <= x <= 4_000_000
                    and 0 <= y <= 4_000_000
                    and all(
                        abs(sx - x) + abs(sy - y) > dist for sx, sy, dist in entries
                    )
                ):
                    result = x * 4_000_000 + y
                    print(result)
                    assert result == 13639962836448
                    exit()
