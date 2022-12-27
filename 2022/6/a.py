from pathlib import Path

with open(Path(__file__).parent.joinpath("input.txt")) as f:
    buffer = f.read()
    result: int | None = None

    for i in range(4, len(buffer)):
        if len(set(buffer[i - 4 : i])) == 4:
            result = i
            break

    assert result == 1623
    print(result)
