import string
from pathlib import Path

with open(Path(__file__).parent.joinpath("input.txt")) as f:
    total = 0
    lines = [line.strip() for line in f.readlines()]
    i = 0

    while i < len(lines):
        first = set(lines[i])
        second = set(lines[i + 1])
        third = set(lines[i + 2])
        item = next(iter(first & second & third))
        total += string.ascii_letters.index(item) + 1
        i += 3

    assert total == 2805
    print(total)
