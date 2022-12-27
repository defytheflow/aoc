import math
from dataclasses import dataclass
from pathlib import Path
from typing import Literal


@dataclass
class Operation:
    type: Literal["+", "*"]
    value: int | Literal["old"]


@dataclass
class Test:
    value: int
    true_monkey: int
    false_monkey: int


@dataclass
class Monkey:
    starting_items: list[int]
    operation: Operation
    test: Test
    n_inspected_items: int = 0


with open(Path(__file__).parent.joinpath("input.txt")) as f:
    monkeys: list[Monkey] = []

    for monkey_data in f.read().split("\n\n"):
        lines = monkey_data.split("\n")

        # parse starting items
        n_round, second = lines[1].split(":")
        starting_items = [int(s.strip()) for s in second.split(",")]

        # parse operation
        n_round, second = lines[2].split("=")
        second = second[5:]
        value = second[2:]
        if value != "old":
            value = int(value)
        assert second[0] in ("+", "*")
        operation = Operation(type=second[0], value=value)

        # parse test
        *n_round, count = lines[3].split(" ")
        *n_round, true_monkey = lines[4].split(" ")
        *n_round, false_monkey = lines[5].split(" ")
        test = Test(
            value=int(count),
            true_monkey=int(true_monkey),
            false_monkey=int(false_monkey),
        )

        monkey = Monkey(starting_items=starting_items, operation=operation, test=test)
        monkeys.append(monkey)

    test_values_product = math.prod(monkey.test.value for monkey in monkeys)

    for _ in range(10_000):
        for monkey in monkeys:
            for item in monkey.starting_items:
                value = (
                    item if monkey.operation.value == "old" else monkey.operation.value
                )
                if monkey.operation.type == "*":
                    item *= value
                elif monkey.operation.type == "+":
                    item += value
                item %= test_values_product

                monkey_index = (
                    monkey.test.true_monkey
                    if item % monkey.test.value == 0
                    else monkey.test.false_monkey
                )

                monkeys[monkey_index].starting_items.append(item)
                monkey.n_inspected_items += 1
            monkey.starting_items = []

    sorted_monkeys = sorted(monkeys, key=lambda monkey: monkey.n_inspected_items)
    print(math.prod(monkey.n_inspected_items for monkey in sorted_monkeys[-2:]))
