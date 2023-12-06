<?php
    $input = file("inputs/4.txt");
    // Test Data:
    // $input = [
    //     "Card 1: 41 48 83 86 17 | 83 86  6 31 17  9 48 53",
    //     "Card 2: 13 32 20 16 61 | 61 30 68 82 17 32 24 19",
    //     "Card 3:  1 21 53 59 44 | 69 82 63 72 16 21 14  1",
    //     "Card 4: 41 92 73 84 69 | 59 84 76 51 58  5 54 83",
    //     "Card 5: 87 83 26 28 32 | 88 30 70 12 93 22 82 36",
    //     "Card 6: 31 18 13 56 72 | 74 77 10 23 35 67 36 11",
    // ];

    $valueSum = 0;

    for($line = 0; $line < count($input); $line++){
        [$header, $lists] = explode(": ", trim($input[$line]));

        $lists = explode(" | ", $lists);
        $winningNumbers = array_unique(explode(" ", minimizeSpaces($lists[0])));
        $ownNumbers = array_unique(explode(" ", minimizeSpaces($lists[1])));

        $value = 0;

        foreach($ownNumbers as $number){
            if(in_array($number, $winningNumbers)){
                $value++;
            }
        }
        
        if($value != 0){
            $valueSum += pow(2, $value-1);
        }
    }

    echo $valueSum . "\n";


    $valueSum = 0;
    $amount = array_fill(0, count($input), 1);

    for($line = 0; $line < count($input); $line++){
        [$header, $lists] = explode(": ", trim($input[$line]));

        $lists = explode(" | ", $lists);
        $winningNumbers = array_unique(explode(" ", minimizeSpaces($lists[0])));
        $ownNumbers = array_unique(explode(" ", minimizeSpaces($lists[1])));

        $value = 0;

        foreach($ownNumbers as $number){
            if(in_array($number, $winningNumbers)){
                $value++;
            }
        }
        
        for($a = 0; $a < $value; $a++){
            $amount[$line+$a+1] += $amount[$line];
        }

        $valueSum += $amount[$line];
    }

    echo $valueSum . "\n";

    function minimizeSpaces($input){
        return preg_replace('!\s+!', ' ', $input);
    }
?>