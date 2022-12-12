with open("./input.txt") as f:
    stack_lines = []
    for line in f:
        if line == "\n":
            break
        stack_lines.append(line)

    stack_lines = stack_lines[-2::-1]
    stacks = []
    for i in range((len(stack_lines[0])) // 4):
        start = i * 4 + 1
        stack = [line[start : start + 1] for line in stack_lines]
        stacks.append([crate for crate in stack if crate != " "])

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
