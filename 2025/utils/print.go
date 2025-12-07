package utils

import "fmt"

func PrintMatrix(matrix [][]rune) {
	for _, line := range matrix {
		for _, char := range line {
			fmt.Printf("%c", char)
		}
		fmt.Println()
	}
}
