from __future__ import annotations

import math
from dataclasses import dataclass
from functools import partial
from pathlib import Path
from typing import Callable, Literal


def main() -> None:
    data = (Path(__file__).parent / "input.txt").read_text().strip()

    result_one = solve_one(data)
    print(result_one)
    assert result_one == 108_240

    result_two = solve_two(data)
    print(result_two)
    assert result_two == 25_712_998_901


def solve_one(data: str) -> int:
    monkeys = parse_input(data)
    return solve(monkeys, 20, lambda worry: math.floor(worry / 3))


def solve_two(data: str) -> int:
    monkeys = parse_input(data)
    global_divisor = math.prod(monkey.divisor for monkey in monkeys)
    return solve(monkeys, 10_000, lambda worry: worry % global_divisor)


def solve(
    monkeys: list[Monkey],
    rounds: int,
    reduce_worry: Callable[[int], int],
) -> int:
    counts = [0] * len(monkeys)

    for _ in range(rounds):
        for i, monkey in enumerate(monkeys):
            while len(monkey.items) > 0:
                item = monkey.items.pop(0)
                new_item = reduce_worry(monkey.operation(item))
                next_monkey = monkey.test(new_item)
                monkeys[next_monkey].items.append(new_item)
                counts[i] += 1

    return math.prod(sorted(counts)[-2:])


@dataclass
class Monkey:
    items: list[int]
    operation: Callable[[int], int]
    test: Callable[[int], int]
    divisor: int


def parse_input(data: str) -> list[Monkey]:
    monkeys: list[Monkey] = []

    def operation(
        op: Literal["+", "*"],
        value: int | Literal["old"],
        worry: int,
    ) -> int:
        amount = worry if value == "old" else int(value)
        if op == "+":
            return worry + amount
        elif op == "*":
            return worry * amount

    def test(divisor: int, true_monkey: int, false_monkey: int, worry: int) -> int:
        return true_monkey if worry % divisor == 0 else false_monkey

    for group in data.split("\n\n"):
        lines = group.split("\n")
        items = [int(i) for i in lines[1].replace("  Starting items: ", "").split(",")]

        op, value = lines[2].replace("  Operation: new = old ", "").split(" ")
        value = int(value) if value != "old" else value
        assert op in ("+", "*")
        operation_fn = partial(operation, op, value)

        divisor = int(lines[3].replace("  Test: divisible by ", ""))
        true_monkey = int(lines[4].replace("    If true: throw to monkey ", ""))
        false_monkey = int(lines[5].replace("    If false: throw to monkey ", ""))
        test_fn = partial(test, divisor, true_monkey, false_monkey)

        monkeys.append(Monkey(items, operation_fn, test_fn, divisor))

    return monkeys


if __name__ == "__main__":
    main()
