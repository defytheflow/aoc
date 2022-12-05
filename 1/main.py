def part_1():
    with open("./input.txt") as f:
        content = f.read()
        lines = sorted(
            sum(map(int, line.split("\n"))) for line in content.split("\n\n")
        )
        print(lines[-1])


def part_2():
    with open("./input.txt") as f:
        content = f.read()
        lines = sorted(
            sum(map(int, line.split("\n"))) for line in content.split("\n\n")
        )
        print(sum(lines[-3:]))


part_1()
part_2()
