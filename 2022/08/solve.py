from pathlib import Path


def main() -> None:
    data = (Path(__file__).parent / "input.txt").read_text().strip()

    result_one = solve_one(data)
    print(result_one)
    assert result_one == 1851

    result_two = solve_two(data)
    print(result_two)
    assert result_two == 574_080


def solve_one(data: str) -> int:
    grid = [[int(c) for c in line] for line in data.split("\n")]
    visible_trees = 0

    for i, row in enumerate(grid):
        if i == 0 or i == len(grid) - 1:
            visible_trees += len(row)
            continue

        for j, current_tree in enumerate(row):
            # fmt: off
            if (
                # edge
                (j == 0 or j == len(row) - 1) or
                # north
                all(grid[k][j] < current_tree for k in range(i))
                # east
                or all(grid[i][k] < current_tree for k in range(len(row) - 1, j, -1))
                # south
                or all(grid[k][j] < current_tree for k in range(len(grid) - 1, i, -1))
                # west
                or all(grid[i][k] < current_tree for k in range(j))
            ):
                visible_trees += 1

    return visible_trees


def solve_two(data: str) -> int:
    grid = [[int(c) for c in line] for line in data.split("\n")]
    max_scenic_score = 1

    for i, row in enumerate(grid):
        if i == 0 or i == len(grid) - 1:
            continue

        for j, current_tree in enumerate(row):
            if j == 0 or j == len(row) - 1:
                continue

            north_score = 0
            for k in range(i - 1, -1, -1):
                north_score += 1
                if grid[k][j] >= current_tree:
                    break

            east_score = 0
            for k in range(j + 1, len(row)):
                east_score += 1
                if grid[i][k] >= current_tree:
                    break

            south_score = 0
            for k in range(i + 1, len(grid)):
                south_score += 1
                if grid[k][j] >= current_tree:
                    break

            west_score = 0
            for k in range(j - 1, -1, -1):
                west_score += 1
                if grid[i][k] >= current_tree:
                    break

            max_scenic_score = max(
                max_scenic_score,
                north_score * east_score * south_score * west_score,
            )

    return max_scenic_score


if __name__ == "__main__":
    main()
