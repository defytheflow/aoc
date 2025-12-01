package main

import (
	"fmt"
	"os"
	"strconv"
	"strings"
)

const DEBUG bool = false

const TOTAL_NUMBERS int = 100
const DIAL_START_NUMBER int = 50

const LEFT byte = 'L'
const RIGHT byte = 'R'

func main() {
	result_one := solve_one()
	fmt.Println(result_one)
	assert(result_one == 962, "Incorrect solve_one() result")
}

func solve_one() int {
	content, err := os.ReadFile("input.txt")

	if err != nil {
		fmt.Println("Error reading file:", err)
		return -1
	}

	dial := DIAL_START_NUMBER
	zeros := 0

	str_content := string(content)

	for _, line := range strings.Split(str_content, "\n") {
		if len(line) == 0 {
			// Last line is empty for whatever reason, skipping -> otherwise crashes
			continue
		}

		firstChar := line[0]
		otherChars := line[1:]

		direction := firstChar
		distance, err := strconv.Atoi(otherChars)

		if err != nil {
			fmt.Println("Error:", err)
			return -1
		}

		distance %= TOTAL_NUMBERS
		prev_dial := dial

		switch direction {
		case LEFT:
			diff := dial - distance

			if diff >= 0 {
				dial = diff
			} else {
				dial = TOTAL_NUMBERS + diff
			}
		case RIGHT:
			dial = (dial + distance) % TOTAL_NUMBERS
		}

		if dial == 0 {
			zeros += 1
		}

		if DEBUG {
			fmt.Printf("DIR - %c, DIST - %2d, DIAL - %d --> %d\n", direction, distance, prev_dial, dial)
		}
	}

	return zeros
}

func assert(condition bool, message string) {
	if !condition {
		panic("Assertion failed: " + message)
	}
}
