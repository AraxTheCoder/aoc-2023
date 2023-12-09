<?php
    $input = file("inputs/9.txt");
    //$input = file("inputs/9-test.txt");

    $sumA= 0;
    $sumB= 0;

    foreach($input as $line){
        $sequenzes = [];
        $sequenzes[] = explode(" ", trim($line));
        $currentSequenz = $sequenzes[0];

        // var_dump($currentSequenz);

        while(!allNull($currentSequenz)){
            $diffs = [];
            for($index = 0; $index < count($currentSequenz)-1; $index++){
                $diffs[] = $currentSequenz[$index+1]  -  $currentSequenz[$index];
            }

            $sequenzes[] = $diffs;
            // var_dump($diffs);
            $currentSequenz = $diffs;
        }

        $nextValue = 0;
        for($index = count($sequenzes)-2; $index >= 0; $index--){
            $nextValue += end($sequenzes[$index]);
        }

        $prevValue = 0;
        for($index = count($sequenzes)-2; $index >= 0; $index--){
            $prevValue = $sequenzes[$index][0] - $prevValue;
        }

        // var_dump($nextValue);
        // return;
        $sumA += $nextValue;
        $sumB += $prevValue;
    }

    var_dump($sumA);
    var_dump($sumB);

    function allNull($array) : bool {
        foreach($array as $element){
            if($element != 0){
                return false;
            }
        }

        return true;
    }
?>