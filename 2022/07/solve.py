from __future__ import annotations

from dataclasses import dataclass, field
from pathlib import Path


@dataclass
class Dir:
    parent: Dir | None
    files: dict[str, int] = field(default_factory=dict)
    dirs: dict[str, Dir] = field(default_factory=dict)


def parse_fs(data: str) -> Dir:
    current = fs = Dir(parent=None)

    for line in data.split("\n"):
        first, *rest = line.split(" ")
        if first == "$":
            cmd = rest[0]
            if cmd == "cd":
                dirname = rest[1]
                if dirname == "..":
                    assert current.parent is not None
                    current = current.parent
                elif dirname == "/":
                    current = fs
                else:
                    assert current is not None
                    current = current.dirs.setdefault(dirname, Dir(parent=current))
        elif first != "dir":
            assert current is not None
            fname = rest[0]
            current.files.setdefault(fname, int(first))

    return fs


dir_sizes: list[int] = []


def compute_size(directory: Dir) -> int:
    size = sum(directory.files.values())

    for dir_ in directory.dirs.values():
        dir_size = compute_size(dir_)
        dir_sizes.append(dir_size)
        size += dir_size

    return size


def solve_one(data: str) -> int:
    fs = parse_fs(data)
    compute_size(fs)
    return sum(size for size in dir_sizes if size <= 100_000)


def solve_two(data: str) -> int:
    fs = parse_fs(data)
    root_size = compute_size(fs)
    needed_size = 30_000_000 - (70_000_000 - root_size)
    return min(size for size in dir_sizes if size >= needed_size)


if __name__ == "__main__":
    data = (Path(__file__).parent / "input.txt").read_text().strip()

    solution_one = solve_one(data)
    print(solution_one)
    assert solution_one == 1_513_699

    solution_two = solve_two(data)
    print(solution_two)
    assert solution_two == 7_991_939
