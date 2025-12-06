package utils

import (
	"fmt"
	"os"
	"path/filepath"
	"runtime"
	"strings"
)

// Reads the contents of a file relative to the caller's directory.
//
// This allows to run and test the solutions from the project root (`go test ./...`).
func ReadInput(filename string) string {
	_, callerFile, _, ok := runtime.Caller(1)
	if !ok {
		panic("failed to determine caller's file path")
	}

	callerDir := filepath.Dir(callerFile)
	absPath := filepath.Join(callerDir, filename)

	data, err := os.ReadFile(absPath)

	if err != nil {
		panic(fmt.Sprintf("failed to read file %q: %v", absPath, err))
	}

	return strings.TrimSpace(string(data))
}
