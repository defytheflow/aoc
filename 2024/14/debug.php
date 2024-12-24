<?php

namespace Day14;

/**
 * @param Robot[] $robots
 */
function draw(array &$robots): void
{
    for ($y = 0; $y < HEIGHT; $y++) {
        echo "<div style='display: flex;'>";
        for ($x = 0; $x < WIDTH; $x++) {
            $count = 0;
            foreach ($robots as $robot) {
                if ($robot->pos()->x == $x && $robot->pos()->y == $y) {
                    $count++;
                }
            }
            $char = $count == 0 ? "." : $count;
            echo "<div style='width: 20px; height: 20px; text-align: center;'>{$char}</div>";
        }
        echo "</div>";
    }
}
