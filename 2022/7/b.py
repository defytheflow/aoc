from __future__ import annotations

from dataclasses import dataclass, field


@dataclass
class Folder:
    name: str
    parent_folder: Folder | None
    entries: list[File | Folder] = field(default_factory=list)

    def add_entry(self, entry: Folder | File) -> None:
        self.entries.append(entry)

    def calculate_size(self) -> int:
        total = 0
        for entry in self.entries:
            if isinstance(entry, File):
                total += entry.size
            else:
                total += entry.calculate_size()
        return total


@dataclass
class File:
    name: str
    size: int


with open("./input.txt") as f:
    root = Folder(name="/", parent_folder=None)
    current_folder = root

    file_iterator = iter(f)
    skip_first_line = next(file_iterator)

    for line in file_iterator:
        line = line.strip()
        words = line.split(" ")

        if line.startswith("$ cd"):
            dest = line.split(" ")[-1]
            if dest == "..":
                current_folder = current_folder.parent_folder
            else:
                new_folder = Folder(name=dest, parent_folder=current_folder)
                current_folder.add_entry(new_folder)
                current_folder = new_folder

        elif words[0].isdigit():
            new_file = File(name=words[1], size=int(words[0]))
            current_folder.add_entry(new_file)

    TOTAL_SPACE = 70_000_000
    USED_SPACE = root.calculate_size()
    AVAILABLE_SPACE = TOTAL_SPACE - USED_SPACE
    NEEDED_SPACE = 30_000_000 - AVAILABLE_SPACE

    folder_sizes_for_deletion = []

    def visit(folder: Folder):
        for entry in folder.entries:
            if isinstance(entry, Folder):
                size = entry.calculate_size()
                if size >= NEEDED_SPACE:
                    folder_sizes_for_deletion.append(size)
                visit(entry)

    visit(root)
    print(min(folder_sizes_for_deletion))
