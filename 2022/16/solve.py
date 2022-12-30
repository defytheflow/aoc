# Solution from:
# https://observablehq.com/@a791ad12e8a3e3b4/advent-of-code-2022-day-16

from collections import deque
from copy import deepcopy
from dataclasses import dataclass, field
from pathlib import Path


@dataclass
class Valve:
    label: str
    rate: int
    links: list[str]
    dists: dict[str, int] = field(default_factory=dict)


Graph = dict[str, Valve]


def dfs(
    graph: Graph,
    current: Valve,
    minutes_left: int,
    opened_valves: list[str],
) -> int:
    current_pressure = sum([graph[valve].rate for valve in opened_valves])
    pressures = [current_pressure * minutes_left]

    for neighbor, dist in current.dists.items():
        if minutes_left - dist - 1 > 0 and neighbor not in opened_valves:
            pressures.append(
                (dist + 1) * current_pressure
                + dfs(
                    graph,
                    current=graph[neighbor],
                    minutes_left=minutes_left - dist - 1,
                    opened_valves=[*opened_valves, neighbor],
                )
            )

    return max(pressures)


def compress_graph(graph: Graph) -> Graph:
    new_graph = deepcopy(graph)

    for valve in new_graph.values():
        if valve.rate == 0 and valve.label != "AA":
            continue

        queue: deque[tuple[Valve, int]] = deque([(valve, 0)])
        visited: set[str] = set()

        while queue:
            v, dist = queue.popleft()

            if v.label in visited:
                continue
            visited.add(v.label)

            if v.rate > 0:
                valve.dists[v.label] = dist

            for neighbor in v.links:
                queue.append((new_graph[neighbor], dist + 1))

        if valve.label in valve.dists:
            del valve.dists[valve.label]

    return {
        label: valve
        for label, valve in new_graph.items()
        if not (valve.rate == 0 and valve.label != "AA")
    }


def solve_one(data: str) -> int:
    graph: dict[str, Valve] = {}

    for line in data.split("\n"):
        first, second = [s.split(" ") for s in line.split(";")]
        label = first[1]
        rate = int(first[-1].split("=")[-1])
        links = [label[:-1] if label[-1] == "," else label for label in second[5:]]
        graph[label] = Valve(label, rate, links)

    new_graph = compress_graph(graph)
    return dfs(new_graph, current=new_graph["AA"], minutes_left=30, opened_valves=[])


def solve_two(data: str) -> ...:
    ...


if __name__ == "__main__":
    data = (Path(__file__).parent / "input.txt").read_text().strip()

    solution_one = solve_one(data)
    print(solution_one)
    assert solution_one == 1940

    # solution_two = solve_two(data)
    # print(solution_two)
    # assert solution_two == ...
