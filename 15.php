<?php
    // $input = file("inputs/15-test.txt");
    $input = file("inputs/15.txt");

    $steps = explode(",", trim($input[0]));

    $sum = 0;

    foreach($steps as $step){
        $sum += holidayHash($step);
    }

    var_dump($sum);

    $hashmap = array_fill(0, 256, []);

    foreach($steps as $step){
        $operationIndex = 0;
        $removeOperationIndex = strpos($step, "-");
        if($removeOperationIndex != false){
            $operationIndex = $removeOperationIndex;
        }

        $assignOperationIndex = strpos($step, "=");
        if($assignOperationIndex != false){
            $operationIndex = $assignOperationIndex;
        }

        $label = substr($step, 0, $operationIndex);
        $value = substr($step, $operationIndex+1);
        $index = holidayHash($label);

        if($removeOperationIndex != false){
            deleteLabel($hashmap[$index], $label);
        }

        if($assignOperationIndex != false){
            replaceOrAdd($hashmap[$index], $label, $value);
        }
    }

    $focusPowerSum = 0;

    for($box = 0; $box < count($hashmap); $box++){
        for($slot = 0; $slot < count($hashmap[$box]); $slot++){
            $focusPower = ($box+1) * ($slot+1) * $hashmap[$box][$slot][1];
            // var_dump($focusPower);
            $focusPowerSum += $focusPower;
        }
    }

    var_dump($focusPowerSum);

    function replaceOrAdd(&$array, $label, $value){
        for($index = 0; $index < count($array); $index++){
            if($array[$index][0] == $label){
                $array[$index] = [$label, $value];
                return;
            }
        }

        $array[] = [$label, $value];
    }

    function deleteLabel(&$array, $label){
        for($index = 0; $index < count($array); $index++){
            if($array[$index][0] == $label){
                unset($array[$index]);
                $array = array_values($array);
                break;
            }
        }
    }

    function holidayHash($string){
        $val = 0;

        foreach(str_split($string) as $char){
            $val += ord($char);
            $val *= 17;
            $val = $val % 256;
        }

        return $val;
    }
?>