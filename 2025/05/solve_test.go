package main

import (
	"aoc2025/utils"
	"testing"
)

func TestOne(t *testing.T) {
	input := utils.ReadInput("input.txt")

	got := solveOne(input)
	want := 681

	if got != want {
		t.Errorf("solveOne() = %d, want %d", got, want)
	}
}

func TestTwo(t *testing.T) {
	input := utils.ReadInput("input.txt")

	got := solveTwo(input)
	want := 348_820_208_020_395

	if got != want {
		t.Errorf("solveTwo() = %d, want %d", got, want)
	}
}
