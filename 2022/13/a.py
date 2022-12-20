from pathlib import Path

PacketData = int | list["PacketData"]


def parse(packet: str) -> list[PacketData]:
    current_list = root_list = []
    prev_lists = []
    current_int = ""

    for char in packet[1:-1]:
        if char == "[":
            new_list = []
            current_list.append(new_list)
            prev_lists.append(current_list)
            current_list = new_list
        elif char == "]":
            if current_int:
                current_list.append(int(current_int))
                current_int = ""
            current_list = prev_lists.pop()
        elif char == ",":
            if current_int:
                current_list.append(int(current_int))
                current_int = ""
        else:
            current_int += char

    if current_int:
        current_list.append(int(current_int))

    return root_list


def compare(left: PacketData, right: PacketData) -> bool | None:
    if isinstance(left, int) and isinstance(right, int):
        if left < right:
            return True
        elif left > right:
            return False
        else:
            return None
    elif isinstance(left, list) and isinstance(right, list):
        for i in range(max(len(left), len(right))):
            if i > len(left) - 1:
                return True
            elif i > len(right) - 1:
                return False
            result = compare(left[i], right[i])
            if result is not None:
                return result
    else:
        return compare(
            [left] if isinstance(left, int) else left,
            [right] if isinstance(right, int) else right,
        )


with open(Path(__file__).parent.joinpath("input.txt")) as f:
    pairs = [line.split("\n") for line in f.read().split("\n\n")]
    indices: list[int] = []

    for i, pair in enumerate(pairs, start=1):
        packet_a = parse(pair[0])
        packet_b = parse(pair[1])

        if compare(packet_a, packet_b):
            indices.append(i)

        assert pair[0].replace(",", ", ") == str(packet_a)
        assert pair[1].replace(",", ", ") == str(packet_b)

    print(sum(indices))
