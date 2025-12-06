package main

import (
	"aoc2025/utils"
	"fmt"
	"strconv"
	"strings"
)

const DEBUG bool = false

func main() {
	input := utils.ReadInput("input.txt")

	resultOne := solveOne(input)
	fmt.Println(resultOne)

	resultTwo := solveTwo(input)
	fmt.Println(resultTwo)
}

func solveOne(input string) int {
	lines := strings.Split(input, "\n")
	total := 0

	for _, line := range lines {
		digits := strings.Split(line, "")

		maxVoltage, _ := strconv.Atoi(digits[0] + digits[1])

		for i, digitI := range digits {
			for _, digitJ := range digits[i+1:] {
				localMaxVoltage, _ := strconv.Atoi(digitI + digitJ)

				if localMaxVoltage > maxVoltage {
					maxVoltage = localMaxVoltage
				}
			}
		}

		total += maxVoltage
	}

	return total
}

func solveTwo(input string) int {
	lines := strings.Split(input, "\n")
	total := 0

	for _, line := range lines {
		result := ""
		start := 0
		remaining := 12

		for remaining > 0 {
			if DEBUG {
				fmt.Printf("Result - \"%s\", start - %d, remaining - %d\n", result, start, remaining)
			}

			end := len(line) - remaining + 1

			bestDigit := byte('0')
			bestIndex := start

			if DEBUG {
				fmt.Printf("Scanning from %d to %d -> \"%s\"\n", start, end, line[start:end])
			}

			for i := start; i < end; i++ {
				if line[i] > bestDigit {
					bestDigit = line[i]
					bestIndex = i
				}
			}

			result += string(bestDigit)
			start = bestIndex + 1
			remaining--
		}

		resultInt, _ := strconv.Atoi(result)
		total += resultInt
	}

	return total
}
