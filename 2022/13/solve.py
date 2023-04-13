from functools import cmp_to_key
from pathlib import Path
from typing import Literal


def main() -> None:
    data = (Path(__file__).parent / "input.txt").read_text().strip()

    result_one = solve_one(data)
    print(result_one)
    assert result_one == 5252

    result_two = solve_two(data)
    print(result_two)
    assert result_two == 20_592


def solve_one(data: str) -> int:
    pairs = [line.split("\n") for line in data.split("\n\n")]
    total = 0

    for i, pair in enumerate(pairs, start=1):
        if compare(eval(pair[0]), eval(pair[1])) == -1:
            total += i

    return total


def solve_two(data: str) -> int:
    pairs = [line.split("\n") for line in data.split("\n\n")]

    packet_a: list[PacketData] = [[2]]
    packet_b: list[PacketData] = [[6]]
    packets = [packet_a, packet_b]

    for pair in pairs:
        packets.append(eval(pair[0]))
        packets.append(eval(pair[1]))

    packets.sort(key=cmp_to_key(compare))
    return (packets.index(packet_a) + 1) * (packets.index(packet_b) + 1)


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


if __name__ == "__main__":
    main()
