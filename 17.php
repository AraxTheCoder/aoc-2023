<?php
    // $input = file("inputs/17-test.txt");
    $input = file("inputs/17.txt");

    $grid = [];

    foreach($input as $y => $line){
        foreach(str_split(trim($line)) as $x => $char){
            $grid[$y][$x] = $char;
        }
    }

    $end = [count($input) - 1, strlen(trim($input[0])) - 1];

    // var_dump($grid);
    // var_dump($end);

    function solve($grid, $end, $minSteps, $maxSteps){
        $visited = [];
        // loss steps posX posY directionX directionY
        $queue = new SplMinHeap();
        $queue->insert([0, 0, 0, 0, 1, 0]);
        $queue->insert([0, 0, 0, 0, 0, 1]);

        while(count($queue) != 0){
            $s = $queue->extract();
            [$loss, $steps, $posX, $posY, $dirX, $dirY] = $s;

            $sKey = $posX . " " . $posY . " " . $dirX . " " . $dirY . " " . $steps;

            if(array_key_exists($sKey, $visited)){
                continue;
            }

            $visited[$sKey] = true;

            if($posX == $end[0] && $posY == $end[1] && $steps >= $minSteps){
                return $loss;
            }

            if($steps < $maxSteps && inside($posX, $posY, $dirX, $dirY, $grid)){
                $queue->insert([$loss + $grid[$posY+$dirY][$posX+$dirX], $steps+1, $posX+$dirX, $posY+$dirY, $dirX, $dirY]);
            }

            // rotate left
            [$dirX, $dirY] = rotateLeft($dirX, $dirY);

            if($minSteps <= $steps && inside($posX, $posY, $dirX, $dirY, $grid)){
                $queue->insert([$loss + $grid[$posY+$dirY][$posX+$dirX], 1, $posX+$dirX, $posY+$dirY, $dirX, $dirY]);
            }

            // rotate right
            [$dirX, $dirY] = rotateRight($dirX, $dirY);

            if($minSteps <= $steps && inside($posX, $posY, $dirX, $dirY, $grid)){
                $queue->insert([$loss + $grid[$posY+$dirY][$posX+$dirX], 1, $posX+$dirX, $posY+$dirY, $dirX, $dirY]);
            }
        }
    }

    var_dump(solve($grid, $end, 1, 3));
    var_dump(solve($grid, $end, 4, 10));

    function rotateLeft($dirX, $dirY){
        if($dirY == -1){
            return [1, 0];
        }

        if($dirY == 1){
            return [-1, 0];
        }

        if($dirX == 1){
            return [0, 1];
        }

        if($dirX == -1){
            return [0, -1];
        }

        var_dump("err");
    }

    function rotateRight($dirX, $dirY){
        if($dirY == -1){
            return [0, 1];
        }

        if($dirY == 1){
            return [0, -1];
        }

        if($dirX == 1){
            return [-1, 0];
        }

        if($dirX == -1){
            return [1, 0];
        }

        var_dump("err");
    }
    // function rotateLeft($dirX, $dirY){
    //     if($dirY == -1){
    //         return [1, 0];
    //     }

    //     if($dirY == 1){
    //         return [-1, 0];
    //     }

    //     if($dirX == 1){
    //         return [0, -1];
    //     }

    //     if($dirX == -1){
    //         return [0, 1];
    //     }

    //     var_dump("err");
    // }

    // function rotateRight($dirX, $dirY){
    //     if($dirY == -1){
    //         return [-1, 0];
    //     }

    //     if($dirY == 1){
    //         return [1, 0];
    //     }

    //     if($dirX == 1){
    //         return [0, 1];
    //     }

    //     if($dirX == -1){
    //         return [0, -1];
    //     }

    //     var_dump("err");
    // }

    function inside($posX, $posY, $dirX, $dirY, $grid){
        return $posX + $dirX >= 0 && $posX + $dirX < count($grid[0]) && $posY + $dirY >= 0 && $posY + $dirY < count($grid);
    }
?>