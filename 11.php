<?php
    $input = file("inputs/11.txt");
    //$input = file("inputs/11-test.txt");

    $galaxy = [];
    $filledColumns = [];
    $filledRows = [];

    for($lineIndex = 0; $lineIndex < count($input); $lineIndex++){
        $line = trim($input[$lineIndex]);
        $chars = str_split($line);

        for($charIndex = 0; $charIndex < count($chars); $charIndex++){
            if($chars[$charIndex] != "."){
                $filledColumns[] = $charIndex;
                $filledRows[] = $lineIndex;
            }
        }

        $galaxy[] = $chars;
    }

    $filledColumns = array_unique($filledColumns);
    $filledRows = array_unique($filledRows);

    $emptyColumns = [];
    $emptyRows = [];

    for($lineIndex = 0; $lineIndex < count($input); $lineIndex++){
        if(!in_array($lineIndex, $filledRows)){
            $emptyRows[] = $lineIndex;
        }
    }

    for($charIndex = 0; $charIndex < count($galaxy[0]); $charIndex++){
        if(!in_array($charIndex, $filledColumns)){
            $emptyColumns[] = $charIndex;
        }
    }

    // var_dump($emptyColumns);
    //var_dump($emptyRows);
    $positions = [];
    // For a
    // $fac = 1;

    // For b
    $fac = 1_000_000-1;

    $lineOffset = 0;
    for($lineIndex = 0; $lineIndex < count($galaxy); $lineIndex++){
        $chars = [];
        $charOffset = 0;

        for($charIndex = 0; $charIndex < count($galaxy[$lineIndex]); $charIndex++){
            $chars[] = $galaxy[$lineIndex][$charIndex];

            if($galaxy[$lineIndex][$charIndex] == "#"){
                $positions[] = [$lineIndex+$lineOffset, $charIndex+$charOffset];
            }

            if(in_array($charIndex, $emptyColumns)){
                $charOffset+=$fac;
            }
        }

        if(in_array($lineIndex, $emptyRows)){
            $lineOffset+=$fac;
        }
    }

    // var_dump($positions);

    $sum = 0;

    // Take manhatten distance between pairs
    for($index = 0; $index < count($positions); $index++){
        for($a = $index; $a < count($positions); $a++){
            [$x1, $y1] = $positions[$index];
            [$x2, $y2] = $positions[$a];

            $dis = abs($x2-$x1) + abs($y2-$y1);
            $sum += $dis;
        }
    }

    var_dump($sum);

    function print2DArray($array){
        foreach($array as $line){
            foreach($line as $elem){
                echo $elem;
            }
            echo "\n";
        }
    }
?>