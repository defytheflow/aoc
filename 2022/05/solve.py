from functools import partial
from pathlib import Path


def solve(data: str, reverse: bool) -> str:
    first, second = data.split("\n\n")

    stack_lines = first.split("\n")[-2::-1]
    stacks: list[list[str]] = []

    for i in range((len(stack_lines[0]) + 1) // 4):
        start = i * 4 + 1
        stack = [line[start : start + 1] for line in stack_lines]
        stacks.append([crate for crate in stack if crate != " "])

    for line in second.split("\n"):
        words = line.split(" ")
        count = int(words[1])
        from_index = int(words[3]) - 1
        to_index = int(words[5]) - 1
        lst = stacks[from_index][-count:]
        stacks[from_index][-count:] = []
        stacks[to_index].extend(reversed(lst) if reverse else lst)

    return "".join(stack[-1] for stack in stacks)


solve_one = partial(solve, reverse=True)
solve_two = partial(solve, reverse=False)


if __name__ == "__main__":
    data = (Path(__file__).parent / "input.txt").read_text().strip()

    solution_one = solve_one(data)
    print(solution_one)
    assert solution_one == "RNZLFZSJH"

    solution_two = solve_two(data)
    print(solution_two)
    assert solution_two == "CNSFCGJSM"
