from functools import cmp_to_key
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

    packet_a: list[PacketData] = [[2]]
    packet_b: list[PacketData] = [[6]]
    packets = [packet_a, packet_b]

    for pair in pairs:
        packets.append(eval(pair[0]))
        packets.append(eval(pair[1]))

    packets.sort(key=cmp_to_key(compare))
    result = (packets.index(packet_a) + 1) * (packets.index(packet_b) + 1)
    assert result == 20592
    print(result)
