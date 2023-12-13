<?php
    $input = file("inputs/13.txt");

    $pattern = [];
    $p1 = 0;
    $p2 = 0;
    foreach($input as $line){
        $line = trim($line);
        if(strlen($line) == 0){
            $row = findReflection($pattern, 0);
            $col = findReflection(transposePattern($pattern), 0);
            $p1 += 100 * ($row+1) + ($col+1);
            $row = findReflection($pattern, 2);
            $col = findReflection(transposePattern($pattern), 2);
            $p2 += 100 * ($row+1) + ($col+1);
            $pattern = [];
        }else{
            $pattern[] = $line;
        }
    }

    $row = findReflection($pattern, 0);
    $col = findReflection(transposePattern($pattern), 0);
    $p1 += 100 * ($row+1) + ($col+1);
    $row = findReflection($pattern, 2);
    $col = findReflection(transposePattern($pattern), 2);
    $p2 += 100 * ($row+1) + ($col+1);

    var_dump($p1);
    var_dump($p2);

    function findReflection($pattern, $numberOfAcceptedMissmatches){
        for($a = 0; $a < count($pattern) - 1; $a++){
            $missmatches = 0;

            for($b = 0; $b < count($pattern); $b++){
                if($a+1+($a-$b) >= 0 && $a+1+($a-$b) < count($pattern) && $pattern[$b] != $pattern[$a+1+($a-$b)]){
                    for($charIndex = 0; $charIndex < strlen($pattern[$b]); $charIndex++){
                        if($pattern[$b][$charIndex] != $pattern[$a+1+($a-$b)][$charIndex]){
                            $missmatches++;
                        }
                    }
                }
            }

            if($missmatches == $numberOfAcceptedMissmatches){
                return $a;
            }
        }

        return -1;
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
?>