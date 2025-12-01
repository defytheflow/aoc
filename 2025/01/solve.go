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
	input := parse_input("input.txt")

	result_one := solve_one(input)
	fmt.Println(result_one)
	assert(result_one == 962, "solve_one()")

	result_two := solve_two(input)
	fmt.Println(result_two)
	assert(result_two == 5782, "solve_two()")
}

func solve_one(input string) int {
	dial := DIAL_START_NUMBER
	zeros := 0

	for _, line := range strings.Split(input, "\n") {
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

func solve_two(input string) int {
	dial := DIAL_START_NUMBER
	zeros := 0

	for _, line := range strings.Split(input, "\n") {
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

		full_rotations := distance / TOTAL_NUMBERS
		zeros += full_rotations

		prev_dial := dial
		distance %= TOTAL_NUMBERS

		assert(distance > 0, "distance invariant")

		switch direction {
		case LEFT:
			new_dial := dial - distance

			if new_dial >= 0 {
				dial = new_dial
			} else {
				dial = TOTAL_NUMBERS + new_dial

				if prev_dial != 0 {
					zeros += 1
				}

				if DEBUG {
					fmt.Printf("DIR - %c, DIST - %2d, DIAL - %2d -> %2d, ZEROS - %d\n", direction, distance, prev_dial, dial, zeros)
				}
				continue
			}
		case RIGHT:
			new_dial := dial + distance

			if new_dial < TOTAL_NUMBERS {
				dial = new_dial
			} else {
				dial = new_dial - TOTAL_NUMBERS

				if prev_dial != 0 {
					zeros += 1
				}

				if DEBUG {
					fmt.Printf("DIR - %c, DIST - %2d, DIAL - %2d -> %2d, ZEROS - %d\n", direction, distance, prev_dial, dial, zeros)
				}
				continue
			}
		}

		assert(dial >= 0 && dial <= TOTAL_NUMBERS-1, "dial invariant")

		if prev_dial != 0 && dial == 0 {
			zeros += 1
		}

		if DEBUG {
			fmt.Printf("DIR - %c, DIST - %2d, DIAL - %2d -> %2d, ZEROS - %d\n", direction, distance, prev_dial, dial, zeros)
		}
	}

	return zeros
}

func parse_input(filename string) string {
	content, err := os.ReadFile(filename)

	if err != nil {
		panic(fmt.Sprintf("Error reading file:", err))
	}

	return string(content)
}

func assert(condition bool, message string) {
	if !condition {
		panic("Assertion failed: " + message)
	}
}
