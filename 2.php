<?php
    $red = 12;
    $green = 13;
    $blue = 14;

    $input = file("inputs/2.txt");
    // Test Data:
    // $input = [
    //     "Game 1: 3 blue, 4 red; 1 red, 2 green, 6 blue; 2 green",
    //     "Game 2: 1 blue, 2 green; 3 green, 4 blue, 1 red; 1 green, 1 blue",
    //     "Game 3: 8 green, 6 blue, 20 red; 5 blue, 4 red, 13 green; 5 green, 1 red",
    //     "Game 4: 1 green, 3 red, 6 blue; 3 green, 6 red; 3 green, 15 blue, 14 red",
    //     "Game 5: 6 red, 1 blue, 3 green; 2 blue, 1 red, 2 green",
    // ];

    $possibleGameIdSum = 0;

    for($line = 0; $line < count($input); $line++){
        $game = trim($input[$line]);
        $colonIndex = strpos($game, ":");

        $id = $line + 1;
        $gameSets = substr($game, $colonIndex + strlen(": "));
        $sets = explode("; ", $gameSets);

        $gamePossible = true;

        foreach($sets as $set){
            if(!$gamePossible){
                break;
            }

            $values = explode(", ", $set);

            foreach($values as $value){
                [$amount, $color] = explode(" ", $value);

                if($color == "red" && $amount > $red){
                    $gamePossible = false;
                    break;
                }else if($color == "green" && $amount > $green){
                    $gamePossible = false;
                    break;
                }else if($color == "blue" && $amount > $blue){
                    $gamePossible = false;
                    break;
                }
            }
        }

        if($gamePossible){
            $possibleGameIdSum += $id;
        }
    }

    echo "Possible games id sum (Part a): " . $possibleGameIdSum . "\n";

    $possibleGamePowerSum = 0;

    for($line = 0; $line < count($input); $line++){
        $game = trim($input[$line]);
        $colonIndex = strpos($game, ":");

        $id = $line + 1;
        $gameSets = substr($game, $colonIndex + strlen(": "));
        $sets = explode("; ", $gameSets);

        $minRed = 0;
        $minGreen = 0;
        $minBlue = 0;

        foreach($sets as $set){
            $values = explode(", ", $set);

            foreach($values as $value){
                [$amount, $color] = explode(" ", $value);

                if($color == "red" && $amount > $minRed){
                    $minRed = $amount;
                }else if($color == "green" && $amount > $minGreen){
                    $minGreen = $amount;
                }else if($color == "blue" && $amount > $minBlue){
                    $minBlue = $amount;
                }
            }
        }

        $possibleGamePowerSum += $minRed * $minGreen * $minBlue;
    }

    echo "Possible games power sum (Part b): " . $possibleGamePowerSum . "\n";
?>