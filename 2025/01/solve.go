package main

import (
	"aoc2025/utils"
	"fmt"
	"strconv"
	"strings"
)

const DEBUG bool = false

const TOTAL_NUMBERS int = 100
const DIAL_START_NUMBER int = 50

const LEFT byte = 'L'
const RIGHT byte = 'R'

func main() {
	input := utils.ReadInput("input.txt")

	resultOne := solveOne(input)
	fmt.Println(resultOne)

	resultTwo := solveTwo(input)
	fmt.Println(resultTwo)
}

func solveOne(input string) int {
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
		distance, _ := strconv.Atoi(otherChars)

		distance %= TOTAL_NUMBERS
		prevDial := dial

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
			fmt.Printf("DIR - %c, DIST - %2d, DIAL - %d --> %d\n", direction, distance, prevDial, dial)
		}
	}

	return zeros
}

func solveTwo(input string) int {
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
		distance, _ := strconv.Atoi(otherChars)

		fullRotations := distance / TOTAL_NUMBERS
		zeros += fullRotations

		prevDial := dial
		distance %= TOTAL_NUMBERS

		utils.Assert(distance > 0, "distance invariant")

		switch direction {
		case LEFT:
			newDial := dial - distance

			if newDial >= 0 {
				dial = newDial
			} else {
				dial = TOTAL_NUMBERS + newDial

				if prevDial != 0 {
					zeros += 1
				}

				if DEBUG {
					fmt.Printf("DIR - %c, DIST - %2d, DIAL - %2d -> %2d, ZEROS - %d\n", direction, distance, prevDial, dial, zeros)
				}
				continue
			}
		case RIGHT:
			newDial := dial + distance

			if newDial < TOTAL_NUMBERS {
				dial = newDial
			} else {
				dial = newDial - TOTAL_NUMBERS

				if prevDial != 0 {
					zeros += 1
				}

				if DEBUG {
					fmt.Printf("DIR - %c, DIST - %2d, DIAL - %2d -> %2d, ZEROS - %d\n", direction, distance, prevDial, dial, zeros)
				}
				continue
			}
		}

		utils.Assert(dial >= 0 && dial <= TOTAL_NUMBERS-1, "dial invariant")

		if prevDial != 0 && dial == 0 {
			zeros += 1
		}

		if DEBUG {
			fmt.Printf("DIR - %c, DIST - %2d, DIAL - %2d -> %2d, ZEROS - %d\n", direction, distance, prevDial, dial, zeros)
		}
	}

	return zeros
}
