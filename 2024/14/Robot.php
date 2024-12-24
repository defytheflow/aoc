<?php

namespace Day14;

class Robot
{
    private function __construct(private Point $pos, private readonly Point $vel) {}

    public static function fromString(string $str): self
    {
        [$pos, $vel] = explode(" ", $str);

        $pos = str_replace("p=", "", $pos);
        $vel = str_replace("v=", "", $vel);

        return new self(Point::fromString($pos), Point::fromString($vel));
    }

    public function move(): void
    {
        $this->pos = $this->pos->move(by: $this->vel);
    }

    public function pos(): Point
    {
        return $this->pos;
    }
}

readonly class Point
{
    private function __construct(public int $x, public int $y) {}

    public static function fromString(string $str): self
    {
        [$x, $y] = explode(",", $str);
        return new self(x: (int) $x, y: (int) $y);
    }

    public function move(self $by): self
    {
        $nextX = $this->x + $by->x;
        $nextY = $this->y + $by->y;

        if ($nextX > 0) {
            $nextX %= WIDTH;
        } else if ($nextX < 0) {
            $nextX = WIDTH + $nextX;
        }

        if ($nextY > 0) {
            $nextY %= HEIGHT;
        } else if ($nextY < 0) {
            $nextY = HEIGHT + $nextY;
        }

        return new self(x: $nextX, y: $nextY);
    }
}
