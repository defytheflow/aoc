from pathlib import Path


class CustomStopError(Exception):
    pass


with open(Path(__file__).parent.joinpath("input.txt")) as f:
    x = 1
    cycle = 0
    pixel = 0

    def next_cycle(count: int | None = None) -> None:
        global x, cycle, pixel
        cycle += 1

        if x - 1 <= pixel <= x + 1:
            print("#", end="")
        else:
            print(".", end="")

        pixel += 1

        if count is not None:
            x += count

        if cycle > 0 and cycle % 40 == 0:
            print()
            pixel = 0

        if cycle == 240:
            raise CustomStopError

    for command in f:
        command = command.rstrip("\n")
        try:
            if command == "noop":
                next_cycle()
            else:
                count = int(command.split(" ")[1])
                next_cycle()
                next_cycle(count)
        except CustomStopError:
            pass
