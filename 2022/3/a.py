import string

with open("./input.txt") as f:
    total = 0
    for line in f:
        line = line.strip()
        length = len(line)
        c1 = set(line[:length // 2])
        c2 = set(line[length // 2:])
        item = next(iter(c1 & c2))
        if item.islower():
            total += string.ascii_lowercase.index(item) + 1
        else:
            total += string.ascii_uppercase.index(item) + 27
    print(total)
