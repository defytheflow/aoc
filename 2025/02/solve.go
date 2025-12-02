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
	assert(resultOne == 64215794229, "solveOne()")

}

func solveOne(input string) int {
	idRanges := strings.Split(input, ",")
	total := 0

	for _, idRange := range idRanges {
		idRangeArr := strings.Split(idRange, "-")

		start, _ := strconv.Atoi(idRangeArr[0])
		end, _ := strconv.Atoi(idRangeArr[1])

		for i := start; i <= end; i++ {
			if isInvalidId(strconv.Itoa(i)) {
				total += i
			}
		}
	}

	return total
}

func isInvalidId(id string) bool {
	if len(id)%2 == 1 {
		return false
	}

	middle := len(id) / 2
	return id[:middle] == id[middle:]
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
