from pathlib import Path

with open(Path(__file__).parent.joinpath("input.txt")) as f:
    total = 0

    for line in f:
        s1, s2 = [[int(n) for n in s.split("-")] for s in line.strip().split(",")]
        (a1, b1), (a2, b2) = s1, s2
        if a2 <= a1 <= b2 or a2 <= b1 <= b2 or a1 <= a2 <= b1 or a1 <= b2 <= b1:
            total += 1

    print(total)
    assert total == 827
