<?php

namespace Day08;

/**
 * @param Tile[][] $map
 */
function draw(array &$map): void
{
    foreach ($map as $row) {
        echo "<div style='display: flex;'>";
        foreach ($row as $tile) {
            $bgColor = $tile->isAntinode ? "red" : "white";
            echo "<div style='width: 20px; height: 20px; background-color: $bgColor; text-align: center;'>{$tile->char}</div>";
        }
        echo "</div>";
    }
    echo "</div>";
}
