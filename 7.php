<?php
    // Treat cards as a base 13 number
    $hierarchy = [
        "A" => 12,
        "K" => 11,
        "Q" => 10,
        "T" => 9,
        "9" => 8,
        "8" => 7,
        "7" => 6, 
        "6" => 5,
        "5" => 4,
        "4" => 3, 
        "3" => 2, 
        "2" => 1,
        "J" => 0,
    ];

    // $input = [
    //     "32T3K 765",
    //     "T55J5 684",
    //     "KK677 28",
    //     "KTJJT 220",
    //     "QQQJA 483",
    // ];
    $input = file("inputs/7.txt");

    $cardNumbersWithBids = [];

    foreach($input as $line){
        [$handOriginal, $bid] = explode(" ", trim($line));
        $highestType = -1;
        $highestCards = null;

        foreach(array_keys($hierarchy) as $cardFilledByJoker){
            $hand = str_replace("J", $cardFilledByJoker, $handOriginal);
            // var_dump($hand);
            $cards = str_split($hand);
        
            $amounts = array_count_values($cards);
            sort($amounts, SORT_NUMERIC);

            // $jokerAmount = substr_count($hand, "J");
            // var_dump($jokerAmount);

            // Highcard
            $type = 0;

            // 5 of a kind
            if($amounts == [5]){
                $type = 6;
            }else
            // 4 of a kind
            if($amounts == [1, 4]){
                $type = 5;
            }else
            // Full house
            if($amounts == [2, 3]){
                $type = 4;
            }else
            // 3 of a kind
            if($amounts == [1, 1, 3]){
                $type = 3;
            }else
            // 2 pair
            if($amounts == [1, 2, 2]){
                $type = 2;
            }else
            // 1 pair
            if($amounts == [1, 1, 1, 2]){
                $type = 1;
            }

            if($highestType <= $type){
                $highestType = $type;
                $highestCards = $cards;
            }
        }

        // var_dump($type);
        // var_dump($hand);

        $cardNumber = 0;

        for($index = 0; $index < 5; $index++){
            $cardNumber += pow(13, 5 - $index - 1) * $hierarchy[str_split($handOriginal)[$index]];
            // var_dump($cardNumber);
        }

        $cardNumber += pow(13, 5) * $highestType;

        // var_dump($cardNumber);
        // echo "\n";
        // return;

        $cardNumbersWithBids[] = [$cardNumber, $bid];
    }

    array_multisort(array_column($cardNumbersWithBids, 0), SORT_ASC, SORT_NUMERIC, $cardNumbersWithBids);

    $sum = 0;

    for($index = 0; $index < count($cardNumbersWithBids); $index++){
        $sum += $cardNumbersWithBids[$index][1] * ($index + 1);
        // var_dump($cardNumbersWithBids[$index][1]);
    }

    var_dump($sum);
?>
