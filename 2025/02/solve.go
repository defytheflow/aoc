package main

import (
	"fmt"
	"math"
	"os"
	"sort"
	"strconv"
	"strings"
)

func main() {
	input := parseInput("input.txt")

	resultOne := solveOne(input)
	fmt.Println(resultOne)
	assert(resultOne == 64215794229, "solveOne()")

	resultTwo := solveTwo(input)
	fmt.Println(resultTwo)
	assert(resultTwo == 85513235135, "solveTwo()")
}

func solveOne(input string) int {
	idRanges := strings.Split(input, ",")
	total := 0

	for _, idRange := range idRanges {
		idRangeArr := strings.Split(idRange, "-")

		start, _ := strconv.Atoi(idRangeArr[0])
		end, _ := strconv.Atoi(idRangeArr[1])

		for i := start; i <= end; i++ {
			if isInvalidIdOne(strconv.Itoa(i)) {
				total += i
			}
		}
	}

	return total
}

func isInvalidIdOne(id string) bool {
	if len(id)%2 == 1 {
		return false
	}

	middle := len(id) / 2
	return id[:middle] == id[middle:]
}

func solveTwo(input string) int {
	idRanges := strings.Split(input, ",")
	total := 0

	for _, idRange := range idRanges {
		idRangeArr := strings.Split(idRange, "-")

		start, _ := strconv.Atoi(idRangeArr[0])
		end, _ := strconv.Atoi(idRangeArr[1])

		for i := start; i <= end; i++ {
			if isInvalidIdTwo(strconv.Itoa(i)) {
				total += i
			}
		}
	}

	return total
}

func isInvalidIdTwo(id string) bool {
	if len(id) < 2 {
		return false
	}

	divisors := divisors(len(id))

	for _, divisor := range divisors {
		if areAllChunksSame(id, divisor) {
			return true
		}
	}

	return false
}

func areAllChunksSame(s string, n int) bool {
	if n <= 0 {
		return false
	}
	if len(s) == 0 {
		return true
	}
	if len(s) < n {
		return false
	}

	chunks := make([]string, 0)
	for i := 0; i < len(s); i += n {
		end := min(i+n, len(s))
		chunks = append(chunks, s[i:end])
	}

	if len(chunks) == 1 {
		return true
	}

	firstChunk := chunks[0]
	for _, chunk := range chunks[1:] {
		if chunk != firstChunk {
			return false
		}
	}

	return true
}

func divisors(n int) []int {
	if n <= 0 {
		return []int{}
	}

	var divisors []int
	sqrtN := int(math.Sqrt(float64(n)))

	for i := 1; i <= sqrtN; i++ {
		if n%i == 0 {
			divisors = append(divisors, i)

			if i != n/i && n/i != n {
				divisors = append(divisors, n/i)
			}
		}
	}

	sort.Ints(divisors)
	return divisors
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
