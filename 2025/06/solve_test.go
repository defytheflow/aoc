package main

import (
	"aoc2025/utils"
	"testing"
)

func TestOne(t *testing.T) {
	input := utils.ReadInput("input.txt")

	got := solveOne(input)
	want := 5_552_221_122_013

	if got != want {
		t.Errorf("solveOne() = %d, want %d", got, want)
	}
}

func TestTwo(t *testing.T) {
	input := utils.ReadInput("input.txt")

	got := solveTwo(input)
	want := 11_371_597_126_232

	if got != want {
		t.Errorf("solveTwo() = %d, want %d", got, want)
	}
}
