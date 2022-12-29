from pathlib import Path


def parse_stacks(data: str) -> list[list[str]]:
    stack_lines = data.split("\n")[-2::-1]
    stacks: list[list[str]] = []

    for i in range((len(stack_lines[0]) + 1) // 4):
        start = i * 4 + 1
        stack = [line[start : start + 1] for line in stack_lines]
        stacks.append([crate for crate in stack if crate != " "])

    return stacks


def solve_one(data: str) -> str:
    first, second = data.split("\n\n")
    stacks = parse_stacks(first)

    for line in second.split("\n"):
        words = line.strip().split(" ")
        count = int(words[1])
        from_index = int(words[3]) - 1
        to_index = int(words[5]) - 1

        for _ in range(count):
            crate = stacks[from_index].pop()
            stacks[to_index].append(crate)

    return "".join(stack[-1] for stack in stacks)


def solve_two(data: str) -> ...:
    first, second = data.split("\n\n")
    stacks = parse_stacks(first)

    for line in second.split("\n"):
        words = line.strip().split(" ")
        count = int(words[1])
        from_index = int(words[3]) - 1
        to_index = int(words[5]) - 1

        temp_stack: list[str] = []
        for _ in range(count):
            crate = stacks[from_index].pop()
            temp_stack.append(crate)

        for crate in reversed(temp_stack):
            stacks[to_index].append(crate)

    return "".join(stack[-1] for stack in stacks)


if __name__ == "__main__":
    data = (Path(__file__).parent / "input.txt").read_text().strip()

    solution_one = solve_one(data)
    print(solution_one)
    assert solution_one == "RNZLFZSJH"

    solution_two = solve_two(data)
    print(solution_two)
    assert solution_two == "CNSFCGJSM"
