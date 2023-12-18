<?php
    // $input = file("inputs/18-test.txt");
    $input = file("inputs/18.txt");
    
    $area = 1;
    $xPos = 0;

    foreach($input as $line){
        $line = trim($line);

        [$dir, $steps, $color] = explode(" ", $line);

        if($dir == "R"){
            $xPos += $steps;
        }else if($dir == "L"){
            $xPos -= $steps;
        }

        if($dir == "D"){
            $area += $xPos * $steps;
        }else if($dir == "U"){
            $area += -$xPos * $steps;
        }

        $area += abs($steps) / 2;

        // echo $area . " " . $xPos . " " . $steps . "\n";
    }

    var_dump($area);

    $dirMap = [
        "0" => "R",
        "1" => "D",
        "2" => "L",
        "3" => "U",
    ];
    $area = 1;
    $xPos = 0;

    foreach($input as $line){
        $line = trim($line);

        [$dir, $steps, $color] = explode(" ", $line);
        $dir = $dirMap[$color[-2]];
        $steps = hexdec(substr($color, 2, 5));
        // var_dump(substr($color, 2, 5));
        // exit();

        if($dir == "R"){
            $xPos += $steps;
        }else if($dir == "L"){
            $xPos -= $steps;
        }

        if($dir == "D"){
            $area += $xPos * $steps;
        }else if($dir == "U"){
            $area += -$xPos * $steps;
        }

        $area += abs($steps) / 2;

        // echo $area . " " . $xPos . " " . $steps . "\n";
    }

    var_dump($area);
?>