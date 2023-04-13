from pathlib import Path


def main() -> None:
    data = (Path(__file__).parent / "input.txt").read_text().strip()

    result_one = solve_one(data)
    print(result_one)
    assert result_one == 4_907_780

    result_two = solve_two(data)
    print(result_two)
    assert result_two == 13_639_962_836_448


def solve_one(data: str) -> int:
    y = 2_000_000
    xs: set[int] = set()

    for line in data.split("\n"):
        sx, sy = [
            int(s[2:]) for s in line[line.index("x") : line.index(":")].split(", ")
        ]
        bx, by = [int(s[2:]) for s in line[line.rindex("x") :].split(", ")]
        dist = abs(sx - bx) + abs(sy - by)

        for x in range(sx - dist, sx + dist + 1):
            if abs(sx - x) + abs(sy - y) <= dist:
                xs.add(x)

    return len(xs) - 1  # minus the beacon position


def solve_two(data: str) -> int:
    entries: list[tuple[int, int, int]] = []

    for line in data.split("\n"):
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
                    return x * 4_000_000 + y

    assert False


if __name__ == "__main__":
    main()
