package main

import (
	"aoc2025/utils"
	"fmt"
	"math"
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
		if areAllChunksEqual(splitIntoChunks(id, divisor)) {
			return true
		}
	}

	return false
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

	return divisors
}

func splitIntoChunks(id string, divisor int) []string {
	chunks := make([]string, 0)

	for i := 0; i < len(id); i += divisor {
		chunks = append(chunks, id[i:i+divisor])
	}

	return chunks
}

func areAllChunksEqual(chunks []string) bool {
	firstChunk := chunks[0]

	for _, chunk := range chunks[1:] {
		if chunk != firstChunk {
			return false
		}
	}

	return true
}
