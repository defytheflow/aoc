import string


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
