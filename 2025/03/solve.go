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
