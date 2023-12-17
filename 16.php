<?php
    $input = file("inputs/16-test.txt");
    $input = file("inputs/16.txt");
    $energized = [];
    $rMap = array_fill(0, count($input), array_fill(0, strlen(trim($input[0])), "."));

    traceBeam($input, $energized, 0, 0, 0, 1);

    // $eCount = 0;
    // foreach($energized as $index => $val){
    //     [$line, $char] = explode("#", $index);

    //     if($rMap[$line][$char] == "."){
    //         $eCount++;
    //     }

    //     $rMap[$line][$char] = $val;
    // }

    // foreach($rMap as $line){
    //     foreach($line as $char){
    //         echo $char;
    //     }
    //     echo "\n";
    // }

    var_dump(calcEnergyFromVisited($energized));

    $maxE = 0;

    // TODO: nur noch nicht besuchte durchlaufen
    for($height = 0; $height < count($input); $height++){
        $e = [];
        traceBeam($input, $e, $height, 0, 0, 1);
        $maxE = max($maxE, calcEnergyFromVisited($e));

        $e = [];
        traceBeam($input, $e, $height, strlen(trim($input[$height]))-1, 0, -1);
        $maxE = max($maxE, calcEnergyFromVisited($e));
    }

    var_dump($maxE);

    for($width = 0; $width < strlen(trim($input[0])); $width++){
        $e = [];
        traceBeam($input, $e, 0, $width, 1, 0);
        $maxE = max($maxE, calcEnergyFromVisited($e));

        $e = [];
        traceBeam($input, $e, count($input)-1, $width, -1, 0);
        $maxE = max($maxE, calcEnergyFromVisited($e));
    }

    // 7943
    var_dump($maxE);

    function calcEnergyFromVisited($energized){
        $visited = [];
        foreach($energized as $index => $val){
            [$line, $char] = explode("#", $index);

            if(!in_array($line . "#" . $char, $visited)){
                $visited[] = $line . "#" . $char;
            }
        }

        return count($visited);
    }

    $count = 0;
    function traceBeam($map, &$energized, $linePos, $charPos, $verDir, $horDir){
        // var_dump($linePos);
        // var_dump($charPos);
        // echo "\n";
        if($linePos < 0 || $charPos < 0){
            return;
        }

        if($linePos >= count($map) || $charPos >= strlen(trim($map[$linePos]))){
            return;
        }

        $currentTile = $map[$linePos][$charPos];
        $key = $linePos . "#" . $charPos . "#" . $verDir . "#" . $horDir;

        // global $count;

        // if($count > 30000){
        //     return;
        // }

        // var_dump($currentTile);
        // var_dump($key);
        if(array_key_exists($key, $energized)){//  && in_array($currentTile, ["."])
            if($energized[$key] == 1){
                return;
            }else{
                $energized[$key]++;
            }
        }
        // $count++;

        if($currentTile == "."){
            $energized[$key] = 1;
            traceBeam($map, $energized, $linePos+$verDir, $charPos+$horDir, $verDir, $horDir);
            return;
        }

        if($currentTile == "/"){
            $energized[$key] = 1;
            // ==> /
            if($horDir == 1){
                traceBeam($map, $energized, $linePos-1, $charPos, -1, 0);
            // / <==
            }else if($horDir == -1){
                traceBeam($map, $energized, $linePos+1, $charPos, 1, 0);
            // |
            // |
            // v
            // /
            }else if($verDir == 1){
                traceBeam($map, $energized, $linePos, $charPos-1, 0, -1);
            // /
            // ^
            // |
            // |
            }else if($verDir == -1){
                traceBeam($map, $energized, $linePos, $charPos+1, 0, 1);
            }
            return;
        }

        if($currentTile =="\\"){
            $energized[$key] = 1;
            // ==> \
            if($horDir == 1){
                traceBeam($map, $energized, $linePos+1, $charPos, +1, 0);
            // \ <==
            }else if($horDir == -1){
                traceBeam($map, $energized, $linePos-1, $charPos, -1, 0);
            // |
            // |
            // v
            // \
            }else if($verDir == 1){
                traceBeam($map, $energized, $linePos, $charPos+1, 0, +1);
            // \
            // ^
            // |
            // |
            }else if($verDir == -1){
                traceBeam($map, $energized, $linePos, $charPos-1, 0, -1);
            }
            return;
        }

        if($currentTile == "-"){
            $energized[$key] = 1;
            // tread as empty space
            if($verDir == 0){         
                traceBeam($map, $energized, $linePos+$verDir, $charPos+$horDir, $verDir, $horDir);
            // |
            // |
            // v
            // -
            }else{
                traceBeam($map, $energized, $linePos, $charPos-1, 0, -1);
                traceBeam($map, $energized, $linePos, $charPos+1, 0, 1);
            }
            return;
        }

        if($currentTile == "|"){
            $energized[$key] = 1;
            // tread as empty space
            // var_dump($horDir);
            // exit();
            if($horDir == 0){        
                traceBeam($map, $energized, $linePos+$verDir, $charPos+$horDir, $verDir, $horDir);
            // ==> |
            }else{
                // echo "1\n";
                traceBeam($map, $energized, $linePos-1, $charPos, -1, 0);
                // echo "2\n";
                traceBeam($map, $energized, $linePos+1, $charPos, 1, 0);
            }
            return;
        }
    }
?>