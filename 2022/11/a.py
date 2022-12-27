import math
from dataclasses import dataclass
from functools import partial
from pathlib import Path
from typing import Callable, Literal

Operation = Callable[[int], int]
Test = Callable[[int], int]


@dataclass
class Monkey:
    items: list[int]
    operation: Operation
    test: Test


def operation(op: Literal["+", "*"], value: int | Literal["old"], worry: int) -> int:
    amount = worry if value == "old" else int(value)
    if op == "+":
        return worry + amount
    elif op == "*":
        return worry * amount


def test(divisor: int, true_monkey: int, false_monkey: int, worry: int) -> int:
    return true_monkey if worry % divisor == 0 else false_monkey


with open(Path(__file__).parent.joinpath("input.txt")) as f:
    monkeys: list[Monkey] = []
    groups = f.read().split("\n\n")

    for group in groups:
        lines = group.split("\n")

        # parse items
        items = [
            int(item) for item in lines[1].replace("  Starting items: ", "").split(",")
        ]

        # parse operation
        op, value = lines[2].replace("  Operation: new = old ", "").split(" ")
        value = int(value) if value != "old" else value
        assert op in ("+", "*")
        operation_fn = partial(operation, op, value)

        # parse test
        divisor = int(lines[3].replace("  Test: divisible by ", ""))
        true_monkey = int(lines[4].replace("    If true: throw to monkey ", ""))
        false_monkey = int(lines[5].replace("    If false: throw to monkey ", ""))
        test_fn = partial(test, divisor, true_monkey, false_monkey)

        monkeys.append(Monkey(items=items, operation=operation_fn, test=test_fn))

    monkey_counts = [0] * len(monkeys)

    for _ in range(20):
        for i, monkey in enumerate(monkeys):
            while len(monkey.items) > 0:
                item = monkey.items.pop(0)
                new_item = math.floor(monkey.operation(item) / 3)
                next_monkey = monkey.test(new_item)
                monkeys[next_monkey].items.append(new_item)
                monkey_counts[i] += 1

    sorted_counts = sorted(monkey_counts, reverse=True)
    result = sorted_counts[0] * sorted_counts[1]
    assert result == 108240
    print(result)
