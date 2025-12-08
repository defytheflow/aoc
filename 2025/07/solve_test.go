package main

import (
	"aoc2025/utils"
	"testing"
)

func TestOne(t *testing.T) {
	input := utils.ReadInput("input.txt")

	got := solveOne(input)
	want := 1_504

	if got != want {
		t.Errorf("solveOne() = %d, want %d", got, want)
	}
}

func TestTwo(t *testing.T) {
	input := utils.ReadInput("input.txt")

	got := solveTwo(input)
	want := 5_137_133_207_830

	if got != want {
		t.Errorf("solveTwo() = %d, want %d", got, want)
	}
}
