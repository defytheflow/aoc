package main

import (
	"aoc2025/utils"
	"fmt"
	"sort"
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

func solveTwo(input string) int {
	parts := strings.Split(input, "\n\n")

	idRanges := parseToIdRanges(parts[0])

	sort.Slice(idRanges, func(i, j int) bool {
		return idRanges[i][0] < idRanges[j][0]
	})

	mergedRanges := [][2]int{idRanges[0]}

	for i := 1; i < len(idRanges); i++ {
		current := mergedRanges[len(mergedRanges)-1]
		next := idRanges[i]

		if rangesOverlap(current, next) {
			mergedRanges[len(mergedRanges)-1] = mergeRanges(current, next)
		} else {
			mergedRanges = append(mergedRanges, next)
		}
	}

	freshCount := 0
	for _, r := range mergedRanges {
		freshCount += r[1] - r[0] + 1 // +1 because inclusive
	}

	return freshCount
}

func rangesOverlap(a, b [2]int) bool {
	return a[0] <= b[1] && b[0] <= a[1]
}

func mergeRanges(a, b [2]int) [2]int {
	start := min(a[0], b[0])
	end := max(a[1], b[1])
	return [2]int{start, end}
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
