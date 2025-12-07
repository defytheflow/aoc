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

	resultTwo := solveTwo(input)
	fmt.Println(resultTwo)
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

func solveTwo(input string) int {
	matrix := utils.ParseToMatrix(input)

	var numbers []string

	// initialize numbers
	for _, char := range matrix[0] {
		numbers = append(numbers, string(char))
	}

	var operators []rune

	for y, line := range matrix[1:] {
		if y == len(matrix)-2 {
			operators = line
			break
		}

		for x, char := range line {
			numbers[x] += string(char)
		}
	}

	var ints []int

	for _, number := range numbers {
		int, _ := strconv.Atoi(strings.TrimSpace(number))
		ints = append(ints, int)
	}

	var operatorsClean []rune

	for _, operator := range operators {
		if operator != ' ' {
			operatorsClean = append(operatorsClean, operator)
		}
	}

	var results []int

	runningTotal := 0
	operatorIndex := 0

	for _, int := range ints {
		if int == 0 {
			results = append(results, runningTotal)
			runningTotal = 0
			operatorIndex++
			continue
		}

		switch operatorsClean[operatorIndex] {
		case '+':
			runningTotal += int
		case '*':
			if runningTotal == 0 {
				runningTotal = 1
			}
			runningTotal *= int
		}
	}

	results = append(results, runningTotal)

	total := 0
	for _, num := range results {
		total += num
	}

	return total
}
