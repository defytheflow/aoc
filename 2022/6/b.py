from pathlib import Path

with open(Path(__file__).parent.joinpath("input.txt")) as f:
    buffer = f.read()
    result: int | None = None

    for i in range(14, len(buffer)):
        if len(set(buffer[i - 14 : i])) == 14:
            result = i
            break

    print(result)
    assert result == 3774
