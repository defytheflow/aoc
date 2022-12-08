stacks = [
    ["H", "R", "B", "D", "Z", "F", "L", "S"],
    ["T", "B", "M", "Z", "R"],
    ["Z", "L", "C", "H", "N", "S"],
    ["S", "C", "F", "J"],
    ["P", "G", "H", "W", "R", "Z", "B"],
    ["V", "J", "Z", "G", "D", "N", "M", "T"],
    ["G", "L", "N", "W", "F", "S", "P", "Q"],
    ["M", "Z", "R"],
    ["M", "C", "L", "G", "V", "R", "T"],
]

with open("./input.txt") as f:
    for line in f:
        words = line.strip().split(" ")
        count = int(words[1])
        from_index = int(words[3]) - 1
        to_index = int(words[5]) - 1

        temp_stack = []
        for _ in range(count):
            crate = stacks[from_index].pop()
            temp_stack.append(crate)

        for crate in reversed(temp_stack):
            stacks[to_index].append(crate)

    print("".join(stack[-1] for stack in stacks))
