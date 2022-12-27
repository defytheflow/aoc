from pathlib import Path


class CustomStopError(Exception):
    pass


with open(Path(__file__).parent.joinpath("input.txt")) as f:
    CYCLES = (20, 60, 100, 140, 180, 220)

    x = 1
    cycle = 0
    total = 0

    def next_cycle(count: int | None = None) -> None:
        global x, cycle, total
        cycle += 1

        if cycle in CYCLES:
            total += x * cycle

        if count is not None:
            x += count

        if cycle == CYCLES[-1]:
            raise CustomStopError

    for command in f:
        command = command.rstrip("\n")
        try:
            if command == "noop":
                next_cycle()
            else:
                count = int(command.split(" ")[-1])
                next_cycle()
                next_cycle(count)
        except CustomStopError:
            print(total)
            assert total == 15140
