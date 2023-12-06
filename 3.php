<?php
    $input = file("inputs/3.txt");
    // $input = [
    //     "467..114..",
    //     "...*......",
    //     "..35..633.",
    //     "......#...",
    //     "617*......",
    //     ".....+.58.",
    //     "..592.....",
    //     "......755.",
    //     "...$.*....",
    //     ".664.598..",
    // ];

    // $partSum = 0;
    // $added = [];

    // // check for each number if there is a symbol adjacent
    // for($line = 0; $line < count($input); $line++){
    //     for($charIndex = 0; $charIndex < strlen($input[$line]); $charIndex++){
    //         $numberStart = $charIndex;
    //         $numberIsIncluded = false;
    //         $numberIsIncludedIndex = 0;

    //         while($charIndex < strlen($input[$line]) && ctype_digit($input[$line][$charIndex])){
    //             if(!$numberIsIncluded){
    //                 $numberIsIncluded = isSymbolAdjacent($input, $line, $charIndex);
                    
    //                 if($numberIsIncluded){
    //                     $numberIsIncludedIndex = $charIndex;
    //                 }
    //             }

    //             $charIndex++;
    //         }

    //         if($numberIsIncluded){
    //             $val = intval(substr($input[$line], $numberStart, $charIndex - $numberStart));
    //             $partSum += $val;

    //             $added[] = $val . "\n";
    //         }
    //     }
    // }

    // echo $partSum . "\n";
    // file_put_contents("comp2.txt", $added);

    $partSum = 0;
    $added = [];

    for($line = 0; $line < count($input); $line++){
        for($charIndex = 0; $charIndex < strlen($input[$line]); $charIndex++){
            if($input[$line][$charIndex] == "*"){
                // Get all nearby numbers
                $numbers = getAdjacentNumbers($input, $line, $charIndex);

                if(count($numbers) >= 2){
                    $added[] = $numbers[0] . "\n";
                    $added[] = $numbers[1] . "\n";
                    $added[] = "\n";
                    $partSum += $numbers[0] * $numbers[1];
                }
            }
        }
    }

    echo $partSum . "\n";
    file_put_contents("comp2.txt", $added);

    function isSymbolAdjacent($matrix, $line, $column) : bool {
        for($offset = -1; $offset <= 1; $offset++){
            $posLine = $line + $offset;

            if($posLine < 0 || $posLine > count($matrix) - 1){
                continue;
            }

            for($offsetInline = -1; $offsetInline <= 1; $offsetInline++){
                $posInline = $column + $offsetInline;

                if($posInline < 0 || $posInline > strlen(trim($matrix[$line])) - 1){
                    continue;
                }

                if(isSymbol($matrix[$posLine][$posInline])){
                    return true;
                }
            }
        }

        return false;
    }

    function getAdjacentNumbers($matrix, $line, $column) : array {
        $numbers = [];

        for($offset = -1; $offset <= 1; $offset++){
            $posLine = $line + $offset;

            if($posLine < 0 || $posLine > count($matrix)){
                continue;
            }

            for($offsetInline = -1; $offsetInline <= 1; $offsetInline++){
                $posInline = $column + $offsetInline;

                if($posInline < 0 || $posInline > strlen(trim($matrix[$line]))){
                    continue;
                }
                
                if($matrix[$posLine][$posInline] != "." && ctype_digit($matrix[$posLine][$posInline])){
                    [$index, $number] = traceNumber($matrix, $posLine, $posInline);

                    // Exclude numbers that start at the same position in same line
                    if(!array_key_exists($index, $numbers)){
                        $numbers[$index] = $number;
                    }
                }
            }
        }

        return array_values($numbers);
    }

    function traceNumber($matrix, $line, $column) : array {
        // go left
        $numberStart = 0;
        while($column >= 0 && ctype_digit($matrix[$line][$column])){
            $column--;
        }

        $numberStart = $column + 1;

        // go right
        while($column < strlen(trim($matrix[$line][$column])) - 1 && ctype_digit($matrix[$line][$column])){
            $column++;
        }

        $column--;

        return [$numberStart . "|" . $line, intval(substr($matrix[$line], $numberStart, $column - $numberStart + 1))];
    }

    function isSymbol($possibleSymbol) : bool {
        if(ctype_digit($possibleSymbol)){
            return false;
        }

        if($possibleSymbol == "."){
            return false;
        }

        return true;
    }
?>