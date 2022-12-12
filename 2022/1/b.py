from pathlib import Path

with open(Path(__file__).parent.joinpath('input.txt')) as f:
    content = f.read()
    lines = sorted(
        sum(map(int, line.split("\n"))) for line in content.split("\n\n")
    )
    print(sum(lines[-3:]))
