<?php

declare(strict_types=1);

namespace Day12;

function main(): void
{
    $input = parseInput("input.txt");

    $resultOne = solveOne($input);
    echo $resultOne, PHP_EOL;
    assert($resultOne == 1_456_082);

    // $resultTwo = solveTwo($input);
    // echo $resultTwo, PHP_EOL;
    // assert($resultTwo == -1);
}

/**
 * @param string[][] $input
 */
function solveOne(array $input): int
{
    $map = &$input;

    /**
     * @var array<string, Point[]>
     */
    $regions = [];

    foreach ($map as $y => $row) {
        foreach ($row as $x => $value) {
            $point = new Point($x, $y, $value);

            foreach ($regions as $_ => $region) {
                if (in_array($point, $region)) {
                    continue 2;
                }
            }

            $regions["$point"] = buildRegion($map, $point);
        }
    }

    $price = 0;

    foreach ($regions as $_ => $region) {
        $area = count($region);
        $perimeter = perimeter($map, $region);
        $price += $area * $perimeter;
    }

    return $price;
}

/**
 * @param string[][] $map
 * @param Point[] $region
 */
function perimeter(array &$map, array &$region): int
{
    $perimeter = 0;

    foreach ($region as $point) {
        $points = [
            $point->top(),
            $point->right(),
            $point->bottom(),
            $point->left(),
        ];

        foreach ($points as $nPoint) {
            if (($map[$nPoint->y][$nPoint->x] ?? null) !== $point->char) {
                $perimeter++;
            }
        }
    }

    return $perimeter;
}

/**
 * @param string[][] $map
 * @param Point[] $visited
 * @return Point[]
 */
function buildRegion(array &$map, Point $point, array &$visited = []): array
{
    $region = [$point];

    foreach (neighbors($map, $point) as $nPoint) {
        if (! in_array($nPoint, $visited)) {
            $visited[] = $nPoint;

            foreach (buildRegion($map, $nPoint, $visited) as $rPoint) {
                if (! in_array($rPoint, $region)) {
                    $region[] = $rPoint;
                }
            }
        }
    }

    return $region;
}

/**
 * @param string[][] $map
 * @return Point[]
 */
function neighbors(array &$map, Point $point): array
{
    return array_filter(
        [
            $point->top(),
            $point->right(),
            $point->bottom(),
            $point->left(),
        ],
        fn($p) => ($map[$p->y][$p->x] ?? null) === $point->char
    );
}

/**
 * @param string[][] $input
 */
function solveTwo(array $input): int
{
    return -1;
}

/**
 * @return string[][]
 */
function parseInput(string $filename): array
{
    $input = file_get_contents(__DIR__ . "/" . $filename);

    if ($input === false) {
        throw new \RuntimeException("File \"$filename\" not found");
    }

    return array_map("str_split", explode(PHP_EOL, trim($input)));
}

readonly class Point
{
    public function __construct(public int $x, public int $y, public string $char) {}

    public function __toString(): string
    {
        return "{$this->x}-{$this->y}-{$this->char}";
    }

    public function top(): self
    {
        return new self(x: $this->x, y: $this->y - 1, char: $this->char);
    }

    public function right(): self
    {
        return new self(x: $this->x + 1, y: $this->y, char: $this->char);
    }

    public function bottom(): self
    {
        return new self(x: $this->x, y: $this->y + 1, char: $this->char);
    }

    public function left(): self
    {
        return new self(x: $this->x - 1, y: $this->y, char: $this->char);
    }
}

main();
