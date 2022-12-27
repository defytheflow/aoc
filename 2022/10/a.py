from pathlib import Path

with open(Path(__file__).parent.joinpath("input.txt")) as f:
    x = 1
    cycle = 0
    total = 0

    def next_cycle(count: int | None = None) -> None:
        global x, cycle, total
        cycle += 1

        if cycle in (20, 60, 100, 140, 180, 220):
            total += x * cycle

        if count is not None:
            x += count

        if cycle == 220:
            assert total == 15140
            print(total)
            exit()

    for command in f:
        command = command.rstrip("\n")

        if command == "noop":
            next_cycle()
        else:
            count = int(command.split(" ")[1])
            next_cycle()
            next_cycle(count)
