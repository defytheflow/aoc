with open("./input.txt") as f:
    grid: list[list[int]] = []
    for line in f:
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

    print(n_visible_trees)
