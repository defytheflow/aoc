<?php

namespace Day14;

class Map
{
    /**
     * @param Robot[][][] $map
     */
    private function __construct(private array $map) {}

    /**
     * @param Robot[] $robots
     */
    public static function create(array &$robots): self
    {

        $map = [];

        for ($y = 0; $y < HEIGHT; $y++) {
            $row = [];

            for ($x = 0; $x < WIDTH; $x++) {
                $rbs = [];

                foreach ($robots as $robot) {
                    if ($robot->pos()->x == $x && $robot->pos()->y == $y) {
                        $rbs[] = $robot;
                    }
                }

                $row[] = $rbs;
            }

            $map[] = $row;
        }

        return new self($map);
    }

    public function move(Robot $robot): void
    {
        $this->remove($robot);
        $robot->move();
        $this->place($robot);
    }

    private function remove(Robot $robot): void
    {
        $robots = &$this->map[$robot->pos()->y][$robot->pos()->x];
        $index = array_search($robot, $robots);
        assert(is_int($index));
        array_splice($robots, $index, 1);
    }

    private function place(Robot $robot): void
    {
        $this->map[$robot->pos()->y][$robot->pos()->x][] = $robot;
    }

    public function safety(): int
    {
        $topLeft = 0;
        for ($y = 0; $y < floor(HEIGHT / 2); $y++) {
            for ($x = 0; $x < floor(WIDTH / 2); $x++) {
                $robots = $this->map[$y][$x];
                $topLeft += count($robots);
            }
        }

        $topRight = 0;
        for ($y = 0; $y < floor(HEIGHT / 2); $y++) {
            for ($x = ceil(WIDTH / 2); $x < WIDTH; $x++) {
                $robots = $this->map[$y][$x];
                $topRight += count($robots);
            }
        }

        $bottomLeft = 0;
        for ($y = ceil(HEIGHT / 2); $y < HEIGHT; $y++) {
            for ($x = 0; $x < floor(WIDTH / 2); $x++) {
                $robots = $this->map[$y][$x];
                $bottomLeft += count($robots);
            }
        }

        $bottomRight = 0;
        for ($y = ceil(HEIGHT / 2); $y < HEIGHT; $y++) {
            for ($x = ceil(WIDTH / 2); $x < WIDTH; $x++) {
                $robots = $this->map[$y][$x];
                $bottomRight += count($robots);
            }
        }

        return $topLeft * $topRight * $bottomLeft * $bottomRight;
    }

    public function hasSurroundedRobot(): bool
    {
        $rows = count($this->map);
        $cols = count($this->map[0]);

        for ($y = 0; $y < $rows; $y++) {
            for ($x = 0; $x < $cols; $x++) {
                if (! empty($this->map[$y][$x])) {
                    if ($this->checkNeighbors($x, $y)) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    private function checkNeighbors(int $x, int $y): bool
    {
        $directions = [
            [-1, -1], [0, -1], [1, -1], // top-left, top, top-right
            [-1,  0],          [1,  0], // left, right
            [-1,  1], [0,  1], [1,  1], // bottom-left, bottom, bottom-right
        ];

        foreach ($directions as [$dx, $dy]) {
            $nx = $x + $dx;
            $ny = $y + $dy;

            if (! isset($this->map[$ny][$nx])) {
                return false;
            }

            if (empty($this->map[$ny][$nx])) {
                return false;
            }
        }

        return true;
    }

    public function has3x3Section(): bool
    {
        $rows = count($this->map);
        $cols = count($this->map[0]);

        for ($y = 0; $y <= $rows - 3; $y++) {
            for ($x = 0; $x <= $cols - 3; $x++) {
                if ($this->check3x3Section($x, $y)) {
                    return true;
                }
            }
        }

        return false;
    }

    private function check3x3Section(int $startX, int $startY): bool
    {
        for ($dy = 0; $dy < 3; $dy++) {
            for ($dx = 0; $dx < 3; $dx++) {
                if (empty($this->map[$startY + $dy][$startX + $dx])) {
                    return false;
                }
            }
        }
        return true;
    }

    public function draw(): void
    {
        foreach ($this->map as $y => $row) {
            echo $y, " ";

            foreach ($row as $x => $robots) {
                $char = count($robots) ?: ".";
                echo $char;
            }

            echo "\n";
        }
    }
}
