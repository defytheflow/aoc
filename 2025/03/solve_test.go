package main

import (
	"aoc2025/utils"
	"testing"
)

func TestOne(t *testing.T) {
	input := utils.ReadInput("input.txt")

	got := solveOne(input)
	want := 17_383

	if got != want {
		t.Errorf("solveOne() = %d, want %d", got, want)
	}
}

func TestTwo(t *testing.T) {
	input := utils.ReadInput("input.txt")

	got := solveTwo(input)
	want := 172_601_598_658_203

	if got != want {
		t.Errorf("solveTwo() = %d, want %d", got, want)
	}
}
