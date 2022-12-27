from pathlib import Path

with open(Path(__file__).parent.joinpath("input.txt")) as f:
    y = 2_000_000
    xs: set[int] = set()

    for line in f:
        line = line.rstrip("\n")
        sensor_x, sensor_y = [
            int(s[2:]) for s in line[line.index("x") : line.index(":")].split(", ")
        ]
        beacon_x, beacon_y = [int(s[2:]) for s in line[line.rindex("x") :].split(", ")]

        distance = abs(sensor_x - beacon_x) + abs(sensor_y - beacon_y)
        start_x = sensor_x - distance
        end_x = sensor_x + distance

        for x in range(start_x, end_x + 1):
            dist = abs(sensor_x - x) + abs(sensor_y - y)
            if dist <= distance:
                xs.add(x)

    n_positions = len(xs) - 1  # minus the beacon position
    assert n_positions == 4907780
    print(n_positions)
