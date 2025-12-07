package utils

import "strings"

func ParseToMatrix(input string) [][]rune {
	var matrix [][]rune

	for _, line := range strings.Split(input, "\n") {
		matrix = append(matrix, []rune(line))
	}

	return matrix
}
