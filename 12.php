<?php
    $input = file("inputs/12.txt");
    //$input = file("inputs/12-test.txt");

    $sum = 0;
    $mem = [];

    foreach($input as $line){
        [$springs, $groupSizes] = explode(" ", trim($line));
        $springs = str_split($springs);
        $groupSizes = explode(",", $groupSizes);

        $sum += calcDiffPoss([... $springs, "."], $groupSizes, 0, 0, 0);
        $mem = [];
    }

    var_dump($sum);

    $sum = 0;

    foreach($input as $line){
        [$springs, $groupSizes] = explode(" ", trim($line));
        $springs = str_split($springs);
        $groupSizes = explode(",", $groupSizes);

        $sum += calcDiffPoss([... $springs, "?", ... $springs, "?", ... $springs, "?", ... $springs, "?", ... $springs, "."], [...$groupSizes,...$groupSizes,...$groupSizes,...$groupSizes,...$groupSizes], 0, 0, 0);
        $mem = [];
    }

    var_dump($sum);

    function calcDiffPoss($springs, $groupSizes, $nextPosition, $sequenzLength, $processedGroupsAmount){
        global $mem;

        $key = $nextPosition . " " . $sequenzLength . " " . $processedGroupsAmount;

        if($mem != null && array_key_exists($key, $mem)){
            return $mem[$key];
        }

        $valueToStore = null;

        if($nextPosition == count($springs)){
            if(count($groupSizes) == $processedGroupsAmount){
                $valueToStore = 1;
            }else{
                $valueToStore = 0;
            }
        }else if($springs[$nextPosition] == "#"){
            $valueToStore = calcDiffPoss($springs, $groupSizes, $nextPosition+1, $sequenzLength+1, $processedGroupsAmount);
        }else if($springs[$nextPosition] == "." || $processedGroupsAmount == count($groupSizes)){
            if($processedGroupsAmount < count($groupSizes) && $sequenzLength == $groupSizes[$processedGroupsAmount]){
                $valueToStore = calcDiffPoss($springs, $groupSizes, $nextPosition+1, 0, $processedGroupsAmount+1);
            }else if($sequenzLength == 0){
                $valueToStore = calcDiffPoss($springs, $groupSizes, $nextPosition+1, 0, $processedGroupsAmount);
            }else{
                $valueToStore = 0;
            }
        }else{
            $poss = calcDiffPoss($springs, $groupSizes, $nextPosition+1, $sequenzLength+1, $processedGroupsAmount);
            $dotPoss = 0;

            if($sequenzLength == $groupSizes[$processedGroupsAmount]){
                $dotPoss = calcDiffPoss($springs, $groupSizes, $nextPosition+1, 0, $processedGroupsAmount+1);
            }else if($sequenzLength == 0){
                $dotPoss = calcDiffPoss($springs, $groupSizes, $nextPosition+1, 0, $processedGroupsAmount);
            }

            $valueToStore = $poss + $dotPoss;
        }

        $mem[$key] = $valueToStore;

        return $valueToStore;
    }
?>