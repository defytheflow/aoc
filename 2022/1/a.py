with open("./input.txt") as f:
    content = f.read()
    lines = sorted(
        sum(map(int, line.split("\n"))) for line in content.split("\n\n")
    )
    print(lines[-1])
