from pathlib import Path

with open(Path(__file__).parent.joinpath("input.txt")) as f:
    grid: list[list[int]] = []
    for line in f:
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

    print(max_scenic_score)
    assert max_scenic_score == 574080
