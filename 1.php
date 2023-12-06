<?php
    // Test Data: 
    // $input = ["1abc2", "pqr3stu8vwx", "a1b2c3d4e5f", "treb7uchet"];

    $input = file("inputs/1.txt");

    $calibrationValuesSum = 0;

    for($line = 0; $line < count($input); $line++){
        // Find first digit
        $firstDigit = 0;
        for($charIndex = 0; $charIndex < strlen($input[$line]); $charIndex++){
            if(is_numeric($input[$line][$charIndex])){
                $firstDigit = $input[$line][$charIndex];
                break;
            }
        }

        // Find last digit
        $lastDigit = 0;
        for($charIndex = strlen($input[$line]) - 1; $charIndex >= 0; $charIndex--){
            if(is_numeric($input[$line][$charIndex])){
                $lastDigit = $input[$line][$charIndex];
                break;
            }
        }

        $digit = $firstDigit * 10 + $lastDigit;

        $calibrationValuesSum += $digit;
    }

    echo "Calibration values sum (Part a): " . $calibrationValuesSum . "\n";

    // Test Data:

    // $input = [
    //     "two1nine",
    //     "eightwothree",
    //     "abcone2threexyz",
    //     "xtwone3four",
    //     "4nineeightseven2",
    //     "zoneight234",
    //     "7pqrstsixteen",
    // ];

    $calibrationValuesSum = 0;

    for($line = 0; $line < count($input); $line++){
        // Find first digit
        $firstDigit = 0;
        for($charIndex = 0; $charIndex < strlen($input[$line]); $charIndex++){
            if(is_numeric($input[$line][$charIndex])){
                $firstDigit = $input[$line][$charIndex];
                break;
            }else{
                $digit = isNumberWord($input[$line], $charIndex);
                if($digit != 0){
                    $firstDigit = $digit;
                    break;
                }
            }
        }

        // Find last digit
        $lastDigit = 0;
        for($charIndex = strlen($input[$line]) - 1; $charIndex >= 0; $charIndex--){
            if(is_numeric($input[$line][$charIndex])){
                $lastDigit = $input[$line][$charIndex];
                break;
            }else{
                $digit = isNumberWord($input[$line], $charIndex);
                if($digit != 0){
                    $lastDigit = $digit;
                    break;
                }
            }
        }

        $digit = $firstDigit * 10 + $lastDigit;

        $calibrationValuesSum += $digit;
    }

    echo "Calibration values sum (Part b): " . $calibrationValuesSum . "\n";

    function isNumberWord($string, $position) : int {
        $numberWords = ["one", "two", "three", "four", "five", "six", "seven", "eight", "nine"];

        $word = substr($string, $position, 5);

        for($numberWord = 0; $numberWord < count($numberWords); $numberWord++){
            if(str_starts_with($word, $numberWords[$numberWord])){
                return $numberWord + 1;
            }
        }

        return 0;
    }
?>