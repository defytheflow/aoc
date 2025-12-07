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
}

func solveOne(input string) int {
	matrix := utils.ParseToMatrix(input)
	placeBeam(matrix)
	splits := placeBeams(matrix)
	return splits
}

func placeBeam(matrix [][]rune) {
	for y, line := range matrix {
		for x, char := range line {
			if char == START {
				matrix[y+1][x] = BEAM
			}
		}
	}
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
