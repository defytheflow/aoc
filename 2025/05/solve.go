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
	parts := strings.Split(input, "\n\n")

	idRanges := parseToIdRanges(parts[0])
	ids := parseToIds(parts[1])

	freshCount := 0

	for _, id := range ids {
		for _, idRange := range idRanges {
			if id >= idRange[0] && id <= idRange[1] {
				freshCount++
				break
			}
		}
	}
	return freshCount
}

func parseToIdRanges(s string) [][2]int {
	var ranges [][2]int

	for _, str := range strings.Split(s, "\n") {
		parts := strings.Split(str, "-")

		start, _ := strconv.Atoi(parts[0])
		end, _ := strconv.Atoi(parts[1])

		ranges = append(ranges, [2]int{start, end})
	}

	return ranges
}

func parseToIds(s string) []int {
	var ints []int

	for _, str := range strings.Split(s, "\n") {
		int, _ := strconv.Atoi(str)
		ints = append(ints, int)
	}

	return ints
}
