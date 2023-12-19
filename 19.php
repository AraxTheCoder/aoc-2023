<?php
    $input = file("inputs/19.txt");
    // $input = file("inputs/19-test.txt");

    $rules = parseRules($input);
    $items = parseItems($input);

    // var_dump($items);
    // var_dump($rules);
    $sum = 0;

    foreach($items as $item){
        $flow = "in";

        while(!in_array($flow, ["A", "R"])){
            $flow = followRule($item, $rules[$flow]);
        }

        // var_dump($flow);

        if($flow == "A"){
            $sum += array_sum($item);
        }
    }

    var_dump($sum);

    $minMax = [];
    $minMax["x"] = [1, 4001];
    $minMax["m"] = [1, 4001];
    $minMax["a"] = [1, 4001];
    $minMax["s"] = [1, 4001];

    $pos = possiblilities($rules, $minMax, "in");

    var_dump($pos);

    function possiblilities($rules, $minMax, $flow){
        if($flow == "A"){
            return rangeProduct($minMax);
        }

        if($flow == "R"){
            return 0;
        }

        $sum = 0;

        foreach($rules[$flow] as $rule){
            $parts = explode(":", $rule);
            // var_dump($parts);

            if(count($parts) == 1){
                $sum += possiblilities($rules, $minMax, $parts[0]);
            }else{
                $valueName = substr($rule, 0, 1);
                $compSymbol = substr($rule, 1, 1);

                $rule = substr($rule, 2);

                [$value, $followFlow] = explode(":", $rule);

                if($compSymbol == "<"){
                    $minMaxCopy = $minMax;
                    $minMaxCopy[$valueName][1] = min($minMaxCopy[$valueName][1], $value);
                    
                    $sum += possiblilities($rules, $minMaxCopy, $followFlow);

                    $minMax[$valueName][0] = max($minMax[$valueName][0], $value);
                }

                if($compSymbol == ">"){
                    $minMaxCopy = $minMax;
                    $minMaxCopy[$valueName][0] = max($minMaxCopy[$valueName][0], $value+1);
                    
                    $sum += possiblilities($rules, $minMaxCopy, $followFlow);
                    
                    $minMax[$valueName][1] = min($minMax[$valueName][1], $value+1);
                }
            }
        }

        return $sum;
    }

    function rangeProduct($minMax){
        $prod = 1;

        foreach($minMax as $range){
            $prod *= max($range[1] - $range[0], 0);
        }

        return $prod;
    }

    function followRule($item, $conditions){
        // var_dump($conditions);
        for($index = 0; $index < count($conditions)-1; $index++){
            $condition = $conditions[$index];
            $valueName = substr($condition, 0, 1);
            $compSymbol = substr($condition, 1, 1);

            $condition = substr($condition, 2);

            [$value, $flow] = explode(":", $condition);

            $itemValue = 0;

            switch($valueName){
                case "x":
                    $itemValue = $item[0];
                    break;
                case "m":
                    $itemValue = $item[1];
                    break;
                case "a":
                    $itemValue = $item[2];
                    break;
                case "s":
                    $itemValue = $item[3];
                    break;
            }

            if($compSymbol == ">" && $itemValue > $value){
                return $flow;
            }

            if($compSymbol == "<" && $itemValue < $value){
                return $flow;
            }

            // var_dump($valueName, $compSymbol, $value, $flow);
            // exit();
        }

        return $conditions[count($conditions)-1];
    }

    function parseRules($input){
        $rules = [];
        $index = 0;
        while(strlen(trim($input[$index])) != 0){
            $line = trim($input[$index]);

            [$name, $workflow] = explode("{", $line);
            $workflow = substr($workflow, 0, strlen($workflow)-1);

            $conditions = explode(",", $workflow);

            $rules[$name] = $conditions;

            // var_dump($name, $conditions);
            // exit();

            $index++;
        }

        return $rules;
    }

    function parseItems($input){
        $items = [];

        $index = 0;
        while(strlen(trim($input[$index])) != 0){
            $index++;
        }
        $index++;

        for(; $index < count($input); $index++){
            $line = trim($input[$index]);
            $line = substr($line, 1, strlen($line)-2);

            $values = explode(",", $line);
            $cleanedValues = [];

            // var_dump(count($values));

            foreach($values as $value){
                // $values[$index] = explode("=", $value)[1];
                $cleanedValues[] = explode("=", $value)[1];
                // exit();
            }

            $items[] = $cleanedValues;
        }

        return $items;
    }
?>