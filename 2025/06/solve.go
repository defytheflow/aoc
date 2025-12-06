package main

import (
	"aoc2025/utils"
	"fmt"
	"strconv"
	"strings"
)

func main() {
	input := utils.ReadInput("input.txt")

	resultOne := solveOne(input)
	fmt.Println(resultOne)
}

func solveOne(input string) int {
	lines := strings.Split(input, "\n")

	var numbers [][]int
	var operators []string

	for _, line := range lines[:len(lines)-1] {
		parts := strings.Split(line, " ")

		var localNumbers []int

		for _, part := range parts {
			part = strings.TrimSpace(part)

			if part != "" {
				n, _ := strconv.Atoi(part)
				localNumbers = append(localNumbers, n)
			}
		}

		numbers = append(numbers, localNumbers)
	}

	for _, op := range strings.Split(lines[len(lines)-1], " ") {
		op = strings.TrimSpace(op)

		if op != "" {
			operators = append(operators, op)
		}
	}

	running := numbers[0]

	for _, nums := range numbers[1:] {
		for i, num := range nums {
			switch operators[i] {
			case "+":
				running[i] += num
			case "*":
				running[i] *= num
			}
		}
	}

	total := 0
	for _, num := range running {
		total += num
	}

	return total
}
