<?php
    $input = file("inputs/10.txt");
    //$input = file("inputs/10-test.txt");

    $loopLength = 0;
    $map = [];
    $loopMap = array_fill(0, count($input), array_fill(0, strlen(trim($input[0])), -1));

    // Find Start and build map
    $sLine = -1;
    $sChar = -1;
    for($index = 0; $index < count($input); $index++){
        $line = $input[$index];
        $pipes = str_split(trim($line));

        for($pipeIndex = 0; $pipeIndex < count($pipes); $pipeIndex++){
            if($pipes[$pipeIndex] == "S"){
                $sLine = $index;
                $sChar = $pipeIndex;
            }

            if($pipes[$pipeIndex] == "."){
                $loopMap[$index][$pipeIndex] = 0;
            }
        }

        $map[] = $pipes;
    }

    $loopMap[$sLine][$sChar] = 1;

    //var_dump($sLine);
    //var_dump($sChar);
    // var_dump($map);


    // | is a vertical pipe connecting north and south.
    // - is a horizontal pipe connecting east and west.
    // L is a 90-degree bend connecting north and east.
    // J is a 90-degree bend connecting north and west.
    // 7 is a 90-degree bend connecting south and west.
    // F is a 90-degree bend connecting south and east.
    // . is ground; there is no pipe in this tile.
    // S is the starting position of the animal; there is a pipe on this tile, but your sketch doesn't show what shape the pipe has.

    // Follow pipe
    $prevLine = $sLine;
    $prevChar = $sChar;
    $currentLine = $sLine;
    $currentChar = $sChar;

    // find first pipe
    if($currentLine-1 > 0 && in_array($map[$currentLine-1][$currentChar], ["|", "F", "7"])){
        $currentLine = $currentLine-1;
    }else if(in_array($map[$currentLine+1][$currentChar], ["|", "J", "L"])){
        $currentLine = $currentLine+1;
    }else if(!in_array($map[$currentLine][max($currentChar-1, 0)], [".", "|"])){
        $currentChar = max($currentChar-1, 0);
    }else if(!in_array($map[$currentLine][min($currentChar+1, count($map[$currentLine]))], [".", "|"])){
        $currentChar = min($currentChar+1, count($map[$currentLine]));
    }

    //var_dump($currentLine);
    //var_dump($currentChar);
    //var_dump($map[$currentLine][$currentChar]);

    $lastDirectionLine = $currentLine - $prevLine;
    $lastDirectionChar = $currentChar - $prevChar;

    do{
        $pipeType = $map[$currentLine][$currentChar];

        //$loopMap[$currentLine][$currentChar] = $loopLength+2;
        $loopMap[$currentLine][$currentChar] = 1;

        //var_dump($pipeType);

        $directionLine = 0;
        $directionChar = 0;

        if($pipeType == "|"){
            if($lastDirectionLine == 1){
                $directionLine = 1;
            }else{
                $directionLine = -1;
            }
        }else if($pipeType == "-"){
            if($lastDirectionChar == 1){
                $directionChar++;
            }else{
                $directionChar--;
            }
        }else if($pipeType == "L"){
            // Von oben nach unten
            if($lastDirectionLine == 1){
                //$directionLine += 1;
                $directionChar += 1;
            }else{
                $directionLine -= 1;
                //$directionChar -= 1;
            }
        }else if($pipeType == "J"){
            // Von oben nach unten
            if($lastDirectionLine == 1){
                //$directionLine += 1;
                $directionChar -= 1;
            }else{
                $directionLine -= 1;
                //$directionChar += 1;
            }
        }else if($pipeType == "7"){
            // Von unten nach oben
            if($lastDirectionLine== -1){
                //$directionLine -= 1;
                $directionChar -= 1;
            }else{
                $directionLine += 1;
                //$directionChar += 1;
            }
        }else if($pipeType == "F"){
            // Von unten nach oben
            if($lastDirectionLine== -1){
                //$directionLine -= 1;
                $directionChar += 1;
            }else{
                $directionLine += 1;
               // $directionChar -= 1;
            }
        }else{
            break;
        }

        // $prevLine = $currentLine;
        // $prevChar = $currentChar;

        $currentLine+=$directionLine;
        $currentChar+=$directionChar;

        $lastDirectionLine  = $directionLine;
        $lastDirectionChar = $directionChar;

        // var_dump($currentLine);
        // var_dump($currentChar);

        $loopLength++;

        // var_dump($currentLine != $sLine || $currentChar != $sChar);

    }while($currentLine != $sLine || $currentChar != $sChar);

    var_dump(($loopLength+1) / 2);

    $area = 0;

    for($lineIndex = 0; $lineIndex < count($loopMap); $lineIndex++){
        for($pipeIndex = 0; $pipeIndex < count($loopMap[$lineIndex]); $pipeIndex++){
            // Part of loop
            if($loopMap[$lineIndex][$pipeIndex] == 1){
                continue;
            }

            $insideRight = false;
            $insideLeft = false;

            for($a = 0; $a < $lineIndex; $a++){
                $partOfLoop = $loopMap[$a][$pipeIndex] == 1;

                if ($partOfLoop&& in_array($map[$a][$pipeIndex], ["-", "L", "F"])){
                    $insideRight = !$insideRight;
                }

                if ($partOfLoop && in_array($map[$a][$pipeIndex], ["-", "7", "J"])){
                    $insideLeft = !$insideLeft;
                }
            }
                
            if($insideRight &&  $insideLeft){
                $area++;
            }
        }
    }

    var_dump($area);
    
    // foreach($loopMap as $line){
    //     foreach($line as $elem){
    //         echo str_pad($elem, 1, " ", STR_PAD_LEFT);
    //         // if($elem == 1){
    //         //     echo 1;
    //         // }else if($elem == 2){
    //         //     echo 2;
    //         // }else{
    //         //     echo 0;
    //         // }
    //     }
    //     echo "\n";
    // }
?>