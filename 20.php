<?php
    // $input = file("inputs/20-test.txt");
    $input = file("inputs/20.txt");

    // Broascast => to all
    // Flip flop (%) => Low send high, low again send low
    // Conjunction (&) => 
    // Button => low to broadcast
    $states = [];
    $startReceivers = [];
    $inputs = [];

    foreach($input as $line){
        [$typeAndName, $receivers] = explode(" -> ", trim($line));
        $receivers = explode(", ", $receivers);

        if($typeAndName == "broadcaster"){
            foreach($receivers as $receiver){
                $startReceivers[] = [false, $receiver];
            }
            continue;
        }

        $type = substr($typeAndName, 0, 1);
        $name = substr($typeAndName, 1);

        foreach($receivers as $receiver){
            if(!array_key_exists($receiver, $inputs)){
                $inputs[$receiver] = [];
            }
            $inputs[$receiver][] = $name;
        }

        // Defaults to Low input
        $pulses = [];
        if($type == "%"){
            // Which pulse the % shopuld send next
            $pulses[] = true;
        }
        $states[$name] = [$pulses, $type, $receivers];
    }

    foreach($states as $stateName => $state){
        if($state[1] == "&"){
            foreach($inputs[$stateName] as $i){
                $states[$stateName][0][$i] = false;
            }
        }
    }

    $lowSignals = 0;
    $highSignals = 0;

    // var_dump($states);
    // var_dump($inputs);
    // return;

    for($press = 0; $press < 1000; $press++){
        $queue = $startReceivers;
        $lowSignals += 1 + count($startReceivers);
        while(count($queue) != 0){
            [$pulse, $senderName] = $queue[0];
            array_shift($queue);

            if(!array_key_exists($senderName, $states)){
                continue;
            }

            $sender = $states[$senderName];

            if($sender[1] == "%" && $pulse){
                continue;
            }

            foreach($sender[2] as $receiver){
                // var_dump($senderName . " " . $receiver);
                $pulse = false;

                if($sender[1] == "%"){
                    $pulse = $states[$senderName][0][0];
                }

                if($sender[1] == "&"){
                    $allHigh = count($states[$senderName][0]) != 0;

                    foreach($states[$senderName][0] as $key => $s){
                        // var_dump($states[$senderName][0]);
                        // var_dump($key);

                        if($s == false){
                            $allHigh = false;
                            break;
                        }
                    }

                    // var_dump($allHigh);

                    if(!$allHigh){
                        $pulse = true;
                    }else{
                        $pulse = false;
                    }
                }

                // $states[$receiver][0] = $pulse;

                if($pulse){
                    $highSignals++;
                }else{
                    $lowSignals++;
                }
                // var_dump($senderName . " => " . $receiver . " = " . $pulse);

                if(array_key_exists($receiver, $states)){
                    array_push($queue, [$pulse, $receiver]);

                    if($states[$receiver][1] == "&"){
                        $states[$receiver][0][$senderName] = $pulse;
                    }
                }
            }

            if($sender[1] == "%"){
                $states[$senderName][0][0] = !$states[$senderName][0][0];
            }
        }
    }

    // var_dump($states);
    // var_dump($lowSignals, $highSignals);
    var_dump($lowSignals * $highSignals);

    $states = [];
    $startReceivers = [];
    $inputs = [];

    foreach($input as $line){
        [$typeAndName, $receivers] = explode(" -> ", trim($line));
        $receivers = explode(", ", $receivers);

        if($typeAndName == "broadcaster"){
            foreach($receivers as $receiver){
                $startReceivers[] = [false, $receiver];
            }
            continue;
        }

        $type = substr($typeAndName, 0, 1);
        $name = substr($typeAndName, 1);

        foreach($receivers as $receiver){
            if(!array_key_exists($receiver, $inputs)){
                $inputs[$receiver] = [];
            }
            $inputs[$receiver][] = $name;
        }

        // Defaults to Low input
        $pulses = [];
        if($type == "%"){
            // Which pulse the % shopuld send next
            $pulses[] = true;
        }
        $states[$name] = [$pulses, $type, $receivers];
    }

    foreach($states as $stateName => $state){
        if($state[1] == "&"){
            foreach($inputs[$stateName] as $i){
                $states[$stateName][0][$i] = false;
            }
        }
    }

    $lowSignals = 0;
    $highSignals = 0;

    // var_dump($states);
    // var_dump($inputs);
    // return;
    // All LV Inputs needs to be true so that rx is fired
    $uniqueInputLV = [];
    $queue = [];

    // var_dump($inputs["lv"]);
    $press = 0;
    while(true){
        $queue = $startReceivers;
        $lowSignals += 1 + count($startReceivers);
        while(count($queue) != 0){
            [$pulse, $senderName] = $queue[0];
            array_shift($queue);

            if(!array_key_exists($senderName, $states)){
                continue;
            }

            $sender = $states[$senderName];

            if($senderName == "lv"){
                foreach($states[$senderName][0] as $key => $i){
                    if($i == true && !array_key_exists($key, $uniqueInputLV)){
                        $uniqueInputLV[$key] = $press+1;
                    }
                }

                if(count($uniqueInputLV) >= count($states[$senderName][0])){
                    var_dump(lcm(array_values($uniqueInputLV)));
                    // why does it takes to long to die?! => xDebug
                    return;
                }
            }

            if($sender[1] == "%" && $pulse){
                continue;
            }

            foreach($sender[2] as $receiver){
                // var_dump($senderName . " " . $receiver);
                $pulse = false;

                if($sender[1] == "%"){
                    $pulse = $states[$senderName][0][0];
                }

                if($sender[1] == "&"){
                    $allHigh = count($states[$senderName][0]) != 0;

                    foreach($states[$senderName][0] as $key => $s){
                        // var_dump($states[$senderName][0]);
                        // var_dump($key);

                        if($s == false){
                            $allHigh = false;
                            break;
                        }
                    }

                    // var_dump($allHigh);

                    if(!$allHigh){
                        $pulse = true;
                    }else{
                        $pulse = false;
                    }
                }

                // $states[$receiver][0] = $pulse;

                if($pulse){
                    $highSignals++;
                }else{
                    $lowSignals++;
                }
                // var_dump($senderName . " => " . $receiver . " = " . $pulse);

                if(array_key_exists($receiver, $states)){
                    array_push($queue, [$pulse, $receiver]);

                    if($states[$receiver][1] == "&"){
                        $states[$receiver][0][$senderName] = $pulse;
                    }
                }
            }

            if($sender[1] == "%"){
                $states[$senderName][0][0] = !$states[$senderName][0][0];
            }
        }

        $press++;
    }

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
?>