<?php
    // Test Data:
    // $times = [7, 15, 30];
    // $distances = [9, 40, 200];

    // Time:        35     93     73     66
    // Distance:   212   2060   1201   1044
    $times = [35, 93, 73, 66];
    $distances = [212, 2060, 1201, 1044];

    // Need to be multiplied together
    $numberOfWaysToWinTotal = calcWaysToWin($times, $distances);
    echo "Total ways to win (Part a): " . $numberOfWaysToWinTotal . "\n";

    // Time:        35937366
    // Distance:   212206012011044
    $times = [35937366];
    $distances = [212206012011044];

    // Need to be multiplied together
    $numberOfWaysToWinTotal = calcWaysToWin($times, $distances);
    echo "Total ways to win (Part b): " . $numberOfWaysToWinTotal . "\n";

    function calcWaysToWin($times, $distances) : int {
        $numberOfWaysToWinTotal = 1;

        for($a = 0; $a < count($times); $a++){
            $numberOfWaysToWin = 0;
    
            for($msButtonPress = 1; $msButtonPress < $times[$a]; $msButtonPress++){
                if($msButtonPress * ($times[$a] - $msButtonPress) > $distances[$a]){
                    $numberOfWaysToWin++;
                }
            }
    
            $numberOfWaysToWinTotal *= $numberOfWaysToWin;
        }

        return $numberOfWaysToWinTotal;
    }
?>