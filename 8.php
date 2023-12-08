<?php
    $input = file("inputs/8.txt");

    $instructions = str_split(trim($input[0]));

    $nodes = [];

    for($lineIndex = 2; $lineIndex < count($input); $lineIndex++){
        $line = $input[$lineIndex];

        [$node, $childNodes] = explode(" = ", trim($line));
        [$leftNode, $rightNode] = explode(", ", substr($childNodes, 1, -1));

        // var_dump($node);
        // var_dump($leftNode);
        // var_dump($rightNode);
        // return;
        $nodes[$node] = [$leftNode, $rightNode];
    }

    // var_dump($nodes);
    // return;

    $currentNode = "AAA";
    $instructionIndex = 0;
    $instructionsLength = count($instructions);
    // var_dump($currentNode);
    // return;
    
    while($currentNode != "ZZZ"){
        $currentInstruction = $instructionIndex % $instructionsLength;

        if($instructions[$currentInstruction] == "L"){
            $currentNode = $nodes[$currentNode][0];
        }else if($instructions[$currentInstruction] == "R"){
            $currentNode = $nodes[$currentNode][1];
        }else{
            var_dump($instructions[$currentInstruction]);
        }

        // var_dump($currentNode);

        $instructionIndex++;
    }

    var_dump($instructionIndex);

    $currentNodes = array_values(array_filter(array_keys($nodes), "endsWithA"));
    $currentNodesLength = count($currentNodes);
    $visitedSteps = [];
    $instructionIndex = 0;
    $instructionsLength = count($instructions);
    // var_dump($currentNodes);
    // return;
    
    foreach($currentNodes as $currentNode){
        $instructionIndex = 0;
        while(!endsWithZ($currentNode)){
            $currentInstruction = $instructionIndex % $instructionsLength;

            if($instructions[$currentInstruction] == "L"){
                $currentNode = $nodes[$currentNode][0];
            }else if($instructions[$currentInstruction] == "R"){
                $currentNode = $nodes[$currentNode][1];
            }else{
                var_dump($instructions[$currentInstruction]);
            }

            // var_dump($currentNode);

            $instructionIndex++;
        }

        $visitedSteps[] = $instructionIndex;
        // var_dump($instructionIndex);
    }

    var_dump(lcm($visitedSteps));

    function gcd($a, $b){
        if ($b == 0)
            return $a;

        return gcd($b, $a % $b);
    }

    function lcm($arr){
        $ans = $arr[0];
        for ($i = 1; $i < count($arr); $i++)
            $ans = ((($arr[$i] * $ans)) / (gcd($arr[$i], $ans)));
        
        return $ans;
    }

    function allVisited($array){
        foreach($array as $element){
            if($element == 0){
                return false;
            }
        }

        return true;
    }

    function endsWithA($var){
        return str_ends_with($var, "A");
    }

    function endsWithZ($var){
        return str_ends_with($var, "Z");
    }
?>