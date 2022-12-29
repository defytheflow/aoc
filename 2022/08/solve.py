from pathlib import Path


def solve_one(data: str) -> int:
    grid: list[list[int]] = []
    for line in data.split("\n"):
        grid.append(list(map(int, line.strip())))

    n_visible_trees = 0
    for i, row in enumerate(grid):

        if i == 0 or i == len(grid) - 1:
            n_visible_trees += len(row)
        else:
            for j, col in enumerate(row):
                current_tree = col
                visible = False

                if j == 0 or j == len(grid) - 1:
                    visible = True

                if not visible:
                    for k in range(0, i):
                        north_tree = grid[k][j]
                        if north_tree >= current_tree:
                            break
                    else:
                        visible = True

                if not visible:
                    for k in range(len(row) - 1, j, -1):
                        east_tree = grid[i][k]
                        if east_tree >= current_tree:
                            break
                    else:
                        visible = True

                if not visible:
                    for k in range(len(grid) - 1, i, -1):
                        south_tree = grid[k][j]
                        if south_tree >= current_tree:
                            break
                    else:
                        visible = True

                if not visible:
                    for k in range(0, j):
                        west_tree = grid[i][k]
                        if west_tree >= current_tree:
                            break
                    else:
                        visible = True

                if visible:
                    n_visible_trees += 1

    return n_visible_trees


def solve_two(data: str) -> int:
    grid: list[list[int]] = []
    for line in data.split("\n"):
        grid.append(list(map(int, line.strip())))

    max_scenic_score = 1
    for i, row in enumerate(grid):
        if i == 0 or i == len(grid) - 1:
            continue

        for j, col in enumerate(row):
            if j == 0 or j == len(grid) - 1:
                continue

            current_tree = col

            north_scenic_score = 0
            for k in range(i - 1, -1, -1):
                north_tree = grid[k][j]
                north_scenic_score += 1
                if north_tree >= current_tree:
                    break

            east_scenic_score = 0
            for k in range(j + 1, len(row)):
                east_tree = grid[i][k]
                east_scenic_score += 1
                if east_tree >= current_tree:
                    break

            south_scenic_score = 0
            for k in range(i + 1, len(grid)):
                south_tree = grid[k][j]
                south_scenic_score += 1
                if south_tree >= current_tree:
                    break

            west_scenic_score = 0
            for k in range(j - 1, -1, -1):
                west_tree = grid[i][k]
                west_scenic_score += 1
                if west_tree >= current_tree:
                    break

            current_scenic_score = (
                north_scenic_score
                * east_scenic_score
                * south_scenic_score
                * west_scenic_score
            )

            if current_scenic_score > max_scenic_score:
                max_scenic_score = current_scenic_score

    return max_scenic_score


if __name__ == "__main__":
    data = (Path(__file__).parent / "input.txt").read_text().strip()

    solution_one = solve_one(data)
    print(solution_one)
    assert solution_one == 1851

    solution_two = solve_two(data)
    print(solution_two)
    assert solution_two == 574080
