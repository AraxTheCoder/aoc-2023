<?php
    $input = file("inputs/21.txt");
    // $input = file("inputs/21-test.txt");

    $map = [];
    foreach($input as $line){
        $m = [];

        foreach(str_split(trim($line)) as $char){
            // char stepWhenAdded Amount
            $m[] = [$char, -1];
        }
        $map[] = $m;
    }

    for($steps = 0; $steps < 64; $steps++){
        step($map, $steps);
    }

    printMap($map);
    var_dump(countPossiblePlots($map));

    function printMap($map){
        foreach($map as $line){
            foreach($line as $char){
                echo $char[0];
            }
            echo "\n";
        }
    }

    function countPossiblePlots($map){
        $plots = 0;

        foreach($map as $line){
            foreach($line as $char){
                if($char[0] == "O"){
                    $plots++;
                }
            }
        }

        return $plots;
    }

    function step(&$map, $step){
        for($y = 0; $y < count($map); $y++){
            for($x = 0; $x < count($map[$y]); $x++){
                if($map[$y][$x][1] == $step-1 && in_array($map[$y][$x][0], ["S", "O"])){
                    markNextSteps($map, $x, $y, $step);
                }
            }
        }
    }

    function markNextSteps(&$map, $x, $y, $step){
        $map[$y][$x] = [".", $step];
        for($dy = -1; $dy <= 1; $dy++){
            for($dx = -1; $dx <= 1; $dx++){
                if(($dx != 0 && $dy != 0) ||  ($dx == 0 && $dy == 0)){
                    continue;
                }

                if(inBounds($map, $x+$dx, $y+$dy) && !in_array($map[$y+$dy][$x+$dx][0], ["#"])){
                    $map[$y+$dy][$x+$dx] = ["O", $step];
                }
            }
        }
    }

    function inBounds($map, $x, $y){
        return $x >= 0 && $x < count($map[0]) && $y >= 0 && $y < count($map);
    }
?>