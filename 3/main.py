import string


def part_1():
    with open("./input.txt") as f:
        total = 0
        for line in f:
            line = line.strip()
            length = len(line)
            c1 = set(line[: length // 2])
            c2 = set(line[length // 2 :])
            item = next(iter(c1 & c2))
            if item.islower():
                total += string.ascii_lowercase.index(item) + 1
            else:
                total += string.ascii_uppercase.index(item) + 27
        print(total)


def part_2():
    with open("./input.txt") as f:
        total = 0
        lines = [line.strip() for line in f.readlines()]
        i = 0
        while i < len(lines):
            first, second, third = map(set, lines[i : i + 3])
            item = next(iter(first & second & third))
            if item.islower():
                total += string.ascii_lowercase.index(item) + 1
            else:
                total += string.ascii_uppercase.index(item) + 27
            i += 3
        print(total)


part_1()
part_2()
