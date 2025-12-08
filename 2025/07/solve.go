package main

import (
	"aoc2025/utils"
	"fmt"
)

const START = 'S'
const BEAM = '|'
const SPLITTER = '^'
const EMPTY = '.'

func main() {
	input := utils.ReadInput("input.txt")

	resultOne := solveOne(input)
	fmt.Println(resultOne)

	resultTwo := solveTwo(input)
	fmt.Println(resultTwo)
}

func solveOne(input string) int {
	matrix := utils.ParseToMatrix(input)
	startY, startX := findStart(matrix)
	matrix[startY][startX] = BEAM
	splits := placeBeams(matrix)
	return splits
}

func placeBeams(matrix [][]rune) int {
	splits := 0

	for y, line := range matrix {
		for x, char := range line {
			if char == BEAM {
				switch safeGet(matrix, y+1, x) {
				case EMPTY:
					safeSet(matrix, y+1, x, BEAM)
				case SPLITTER:
					first := safeSet(matrix, y+1, x-1, BEAM)
					second := safeSet(matrix, y+1, x+1, BEAM)

					if first || second {
						splits++
					}
				}
			}
		}
	}

	return splits
}

func solveTwo(input string) int {
	matrix := utils.ParseToMatrix(input)
	startY, startX := findStart(matrix)
	memo := map[[2]int]int{}
	return countPaths(memo, matrix, startY+1, startX)
}

func countPaths(memo map[[2]int]int, matrix [][]rune, y, x int) int {
	if y < 0 || y >= len(matrix) || x < 0 || x >= len(matrix[0]) {
		return 1
	}

	pos := [2]int{y, x}
	if val, ok := memo[pos]; ok {
		return val
	}

	var total int
	cell := matrix[y][x]

	switch cell {
	case EMPTY:
		total = countPaths(memo, matrix, y+1, x)
	case SPLITTER:
		left := countPaths(memo, matrix, y+1, x-1)
		right := countPaths(memo, matrix, y+1, x+1)
		total = left + right
	}

	memo[pos] = total
	return total
}

func findStart(matrix [][]rune) (int, int) {
	for y, row := range matrix {
		for x, cell := range row {
			if cell == START {
				return y, x
			}
		}
	}
	return -1, -1
}

func safeGet(matrix [][]rune, y int, x int) rune {
	if y >= 0 && y < len(matrix) && x >= 0 && x < len(matrix[0]) {
		return matrix[y][x]
	}
	return -1
}

func safeSet(matrix [][]rune, y int, x int, char rune) bool {
	if y >= 0 && y < len(matrix) && x >= 0 && x < len(matrix[0]) {
		matrix[y][x] = char
		return true
	}
	return false
}
