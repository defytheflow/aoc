package main

import (
	"fmt"
	"os"
	"strconv"
	"strings"
)

func main() {
	input := parseInput("input.txt")

	resultOne := solveOne(input)
	fmt.Println(resultOne)
	assert(resultOne == 17383, "solveOne()")
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

func parseInput(filename string) string {
	content, err := os.ReadFile(filename)

	if err != nil {
		panic(fmt.Sprintf("Error reading file:", err))
	}

	return strings.TrimSuffix(string(content), "\n")
}

func assert(condition bool, message string) {
	if !condition {
		panic("Assertion failed: " + message)
	}
}
