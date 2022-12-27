from pathlib import Path
from typing import Literal

PacketData = int | list["PacketData"]


def compare(left: PacketData, right: PacketData) -> Literal[-1, 1, 0]:
    if isinstance(left, int) and isinstance(right, int):
        if left < right:
            return -1
        elif left > right:
            return 1
        else:
            return 0
    elif isinstance(left, list) and isinstance(right, list):
        for i in range(max(len(left), len(right))):
            if i > len(left) - 1:
                return -1
            elif i > len(right) - 1:
                return 1
            result = compare(left[i], right[i])
            if result != 0:
                return result
        return 0
    else:
        return compare(
            [left] if isinstance(left, int) else left,
            [right] if isinstance(right, int) else right,
        )


with open(Path(__file__).parent.joinpath("input.txt")) as f:
    pairs = [line.split("\n") for line in f.read().split("\n\n")]
    total = 0

    for i, pair in enumerate(pairs, start=1):
        if compare(eval(pair[0]), eval(pair[1])) == -1:
            total += i

    print(total)
    assert total == 5252
