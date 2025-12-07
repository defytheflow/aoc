package main

import (
	"aoc2025/utils"
	"fmt"
)

const ROLL_OF_PAPER rune = '@'
const EMPTY rune = '.'
const MAX_ADJACENT_ROLLS_COUNT = 4

func main() {
	input := utils.ReadInput("input.txt")

	resultOne := solveOne(input)
	fmt.Println(resultOne)

	resultTwo := solveTwo(input)
	fmt.Println(resultTwo)
}

func solveOne(input string) int {
	matrix := utils.ParseToMatrix(input)
	rolls := 0

	for y, row := range matrix {
		for x, col := range row {
			if col == ROLL_OF_PAPER {
				neighbors := getNeighbors(y, x, matrix)

				if Count(neighbors, ROLL_OF_PAPER) < MAX_ADJACENT_ROLLS_COUNT {
					rolls++
				}
			}
		}
	}

	return rolls
}

func solveTwo(input string) int {
	matrix := utils.ParseToMatrix(input)
	removedRolls := 0
	didRemove := true

	for didRemove {
		didLocalRemove := false

		for y, row := range matrix {
			for x, col := range row {
				if col == ROLL_OF_PAPER {
					neighbors := getNeighbors(y, x, matrix)

					if Count(neighbors, ROLL_OF_PAPER) < MAX_ADJACENT_ROLLS_COUNT {
						matrix[y][x] = EMPTY
						removedRolls++
						didLocalRemove = true
					}
				}
			}
		}

		didRemove = didLocalRemove
	}

	return removedRolls
}

func getNeighbors(y int, x int, matrix [][]rune) []rune {
	var neighbors []rune

	rows := len(matrix)
	cols := len(matrix[0])

	directions := [8][2]int{
		{-1, -1},
		{-1, 0},
		{-1, 1},
		{0, -1},
		{0, 1},
		{1, -1},
		{1, 0},
		{1, 1},
	}

	for _, dir := range directions {
		nx, ny := x+dir[0], y+dir[1]

		if nx >= 0 && nx < cols && ny >= 0 && ny < rows {
			neighbors = append(neighbors, matrix[ny][nx])
		}
	}

	return neighbors
}

func Count[T comparable](slice []T, target T) int {
	count := 0
	for _, item := range slice {
		if item == target {
			count++
		}
	}
	return count
}
