import string
from pathlib import Path

with open(Path(__file__).parent.joinpath('input.txt')) as f:
    total = 0
    lines = [line.strip() for line in f.readlines()]
    i = 0
    while i < len(lines):
        first, second, third = map(set, lines[i:i + 3])
        item = next(iter(first & second & third))
        total += string.ascii_letters.index(item) + 1
        i += 3
    print(total)
