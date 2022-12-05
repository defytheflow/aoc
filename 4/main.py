def part_1():
    with open("./input.txt") as f:
        total = 0
        for line in f:
            s1, s2 = [[int(n) for n in s.split("-")] for s in line.strip().split(",")]
            if s1[0] <= s2[0] and s1[1] >= s2[1] or s2[0] <= s1[0] and s2[1] >= s1[1]:
                total += 1
        print(total)


part_1()
