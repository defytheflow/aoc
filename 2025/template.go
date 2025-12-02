package main

import (
	"fmt"
	"os"
	"strings"
)

const TODO int = -1

func main() {
	input := parseInput("input.txt")

	resultOne := solveOne(input)
	fmt.Println(resultOne)
	assert(resultOne == TODO, "solveOne()")

	resultTwo := solveTwo(input)
	fmt.Println(resultTwo)
	assert(resultTwo == TODO, "solveTwo()")
}

func solveOne(input string) int {
	return TODO
}

func solveTwo(input string) int {
	return TODO
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
