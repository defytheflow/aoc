from pathlib import Path

with open(Path(__file__).parent.joinpath("input.txt")) as f:
    x = 1
    cycle = 0
    current_pixel = 0

    def next_cycle(count: int | None = None) -> None:
        global x, cycle, current_pixel
        cycle += 1

        if x - 1 <= current_pixel <= x + 1:
            print("#", end="")
        else:
            print(".", end="")

        current_pixel += 1

        if count is not None:
            x += count

        if cycle > 0 and cycle % 40 == 0:
            print()
            current_pixel = 0

        if cycle == 240:
            exit()

    for command in f:
        command = command.rstrip("\n")

        if command == "noop":
            next_cycle()
        else:
            count = int(command.split(" ")[1])
            next_cycle()
            next_cycle(count)
