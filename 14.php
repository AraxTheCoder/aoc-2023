<?php
    // $input = file("inputs/14-test.txt");
    $input = file("inputs/14.txt");

    $load1 = calcLoadOnNorth($input);
    var_dump($load1);

    $matrix = [];
    foreach($input as $line){
        $matrix[] = trim($line);
    }

    $prevs= [$matrix];
    $cycleLength = 0;
    $cycleStart = 0;

    for($cycle = 0; $cycle < 1000000000; $cycle++){
        // North
        $matrix = roll($matrix);
        // west
        $matrix = roll(transposePattern($matrix));
        // south
        $matrix = roll(flipHorizontal(transposePattern($matrix)));
        // east
        $matrix = roll(flipHorizontal(transposePattern($matrix)));
        $matrix = flipHorizontal(transposePattern(flipHorizontal($matrix)));
        // printMatrix($matrix);

        if(in_array($matrix, $prevs)){
            $cycleStart = array_search($matrix, $prevs);
            $cycleLength = $cycle - $cycleStart + 1;
            // var_dump($cycleLength);
            break;
        }

        $prevs[] = $matrix;
    }

    foreach($prevs as $index=>$value){
        if($index >= $cycleStart && $index % $cycleLength == 1000000000 % $cycleLength){
            $load2 = calcLoad($prevs[$index]);
            var_dump($load2);
        }
    }

    function printMatrix($array){
        foreach($array as $elem){
            echo $elem . "\n";
        }

        echo "\n";
    }

    function roll($input){
        $newMatrix = array_fill(0, count($input), str_repeat(".", strlen($input[0])));

        for($charIndex = 0; $charIndex < strlen(trim($input[0])); $charIndex++){
            $wallOffset = 0;
    
            for($lineIndex = 0; $lineIndex < count($input); $lineIndex++){
                if(in_array($input[$lineIndex][$charIndex], ["#", "X"])){
                    $wallOffset = $lineIndex + 1;
                    $newMatrix[$lineIndex][$charIndex] = $input[$lineIndex][$charIndex];
                }
    
                if($input[$lineIndex][$charIndex] == "O"){
                    $newMatrix[$wallOffset][$charIndex] = "O";
                    $wallOffset++;
                }
            }
    
            //var_dump($load - $cLoad);
        }

        return $newMatrix;
    }

    function calcLoad($input){
        $load = 0;

        for($charIndex = 0; $charIndex < strlen(trim($input[0])); $charIndex++){    
            $cload = $load;
            
            for($lineIndex = 0; $lineIndex < count($input); $lineIndex++){    
                if($input[$lineIndex][$charIndex] == "O"){
                    $load += count($input) - $lineIndex;
                }
            }
        }

        return $load;
    }

    function calcLoadOnNorth($input){
        $load = 0;

        for($charIndex = 0; $charIndex < strlen(trim($input[0])); $charIndex++){
            $wallOffset = count($input);
    
            $cLoad = $load;
    
            for($lineIndex = 0; $lineIndex < count($input); $lineIndex++){
                if($input[$lineIndex][$charIndex] == "#"){
                    $wallOffset = count($input) - $lineIndex - 1;
                }
    
                if($input[$lineIndex][$charIndex] == "O"){
                    $load += $wallOffset;
                    $wallOffset--;
                }
            }
    
            // var_dump($load - $cLoad);
        }

        return $load;
    }

    function transposePattern($pattern){
        $transposedPattern = array_fill(0, strlen($pattern[0]), "");

        for($charIndex = 0; $charIndex < strlen($pattern[0]); $charIndex++){
            for($lineIndex = 0; $lineIndex < count($pattern); $lineIndex++){
                $transposedPattern[$charIndex] .= $pattern[$lineIndex][$charIndex];
            }
        }

        return $transposedPattern;
    }

    function flipHorizontal($pattern){
        $transposedPattern = array_fill(0, strlen($pattern[0]), "");

        for($lineIndex = 0; $lineIndex < count($pattern); $lineIndex++){
            $transposedPattern[count($pattern)-$lineIndex-1] = $pattern[$lineIndex];
        }

        return $transposedPattern;
    }
?>