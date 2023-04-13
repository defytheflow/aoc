from __future__ import annotations

from dataclasses import dataclass, field
from pathlib import Path


def main() -> None:
    data = (Path(__file__).parent / "input.txt").read_text().strip()

    result_one = solve_one(data)
    print(result_one)
    assert result_one == 1_513_699

    result_two = solve_two(data)
    print(result_two)
    assert result_two == 7_991_939


def solve_one(data: str) -> int:
    fs = parse_fs(data)
    _, dir_sizes = compute_size(fs)
    return sum(size for size in dir_sizes if size <= 100_000)


def solve_two(data: str) -> int:
    fs = parse_fs(data)
    root_size, dir_sizes = compute_size(fs)
    needed_size = 30_000_000 - (70_000_000 - root_size)
    return min(size for size in dir_sizes if size >= needed_size)


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


def compute_size(
    directory: Dir,
    dir_sizes: list[int] | None = None,
) -> tuple[int, list[int]]:
    dir_sizes = dir_sizes or []
    size = sum(directory.files.values())

    for dir_ in directory.dirs.values():
        dir_size, _ = compute_size(dir_, dir_sizes)
        dir_sizes.append(dir_size)
        size += dir_size

    return size, dir_sizes


if __name__ == "__main__":
    main()
