<?php
    $GLOBALS["input"] = file("inputs/5.txt");
    // $GLOBALS["input"] = file("inputs/5-test.txt");

    $initialSeedRangesString = explode(" ", explode(": ", $input[0])[1]);
    $initialSeedRanges = [];

    for($index = 0; $index < count($initialSeedRangesString); $index+=2){
        // Add Ranges with [0] = Start and [1] = Length
        $initialSeedRanges[] = [intval($initialSeedRangesString[$index]), intval($initialSeedRangesString[$index+1])];
    }

    $seedToSoilMap = [[]];
    $soilToFertilizerMap = [[]];
    $fertilizerToWaterMap = [[]];
    $waterToLightMap = [[]];
    $lightToTemperaturMap = [[]];
    $temperaturToHumidityMap = [[]];
    $humidityToLocationMap = [[]];

    $line = 1;
    $seedToSoilMap = buildMap("seed-to-soil map:");
    $soilToFertilizerMap = buildMap("soil-to-fertilizer map:");
    $fertilizerToWaterMap = buildMap("fertilizer-to-water map:");
    $waterToLightMap = buildMap("water-to-light map:");
    $lightToTemperaturMap = buildMap("light-to-temperature map:");
    $temperaturToHumidityMap = buildMap("temperature-to-humidity map:");
    $humidityToLocationMap = buildMap("humidity-to-location map:");

    $locations = [];
    foreach($initialSeedRangesString as $seed){
        $soil = mapValue($seedToSoilMap, $seed);
        $fertilizer = mapValue($soilToFertilizerMap, $soil);
        $water = mapValue($fertilizerToWaterMap, $fertilizer);
        $light = mapValue($waterToLightMap, $water);
        $tempratur = mapValue($lightToTemperaturMap, $light);
        $humidity = mapValue($temperaturToHumidityMap, $tempratur);
        $location = mapValue($humidityToLocationMap, $humidity);

        $locations[] = $location;
    }

    echo min($locations) . "\n";

    $locations = [];
    $soil = mapRanges($seedToSoilMap, $initialSeedRanges);
    // var_dump($soil);
    // break;
    $fertilizer = mapRanges($soilToFertilizerMap, $soil);
    // var_dump($fertilizer);
    // break;
    $water = mapRanges($fertilizerToWaterMap, $fertilizer);
    // var_dump($water);
    // break;
    $light = mapRanges($waterToLightMap, $water);
    // var_dump($light);
    // break;
    $tempratur = mapRanges($lightToTemperaturMap, $light);
    // var_dump($tempratur);
    // break;
    $humidity = mapRanges($temperaturToHumidityMap, $tempratur);
    // var_dump($humidity);
    // break;
    $location = mapRanges($humidityToLocationMap, $humidity);
    // var_dump($location);
    // break;

    foreach($location as $l){
        $locations[] = $l[0];
    }

    // 41222968 <== result
    echo min($locations) . "\n";

    // es können mehrere values zurückgegeben werden jenachdem ob 
    function mapRanges($map, $ranges) : array{
        $mappedRanges = [];

        foreach($ranges as $range){
            foreach(mapRange($map, $range) as $r){
                array_push($mappedRanges, $r);
            }
        }

        return $mappedRanges;
    }

    // Range[1] = Len
    // Range[0] = start

    // MapEntry[0] = DestStart
    // MapEntry[1] = SrcStart
    // MapEntry[2] = Len
    function mapRange($map, $range) : array{
        $ranges = [];

        while($range[1] > 0){
            $foundMappingRange = false;
            $closestRangeStart = $range[1];
            foreach($map as $mapEntry){
                [$dst, $src, $length] = $mapEntry;

                if($src <= $range[0] && $range[0] < $src + $length){
                    $offset = $range[0] - $src;
                    $missingRangeLength = min($length - $offset, $range[1]);

                    $ranges[] = [$dst+$offset, $missingRangeLength];
                    $range[0] += $missingRangeLength;
                    $range[1] -= $missingRangeLength;
                    $foundMappingRange = true;
                    break;
                }

                if($range[0] < $src){
                    $closestRangeStart = min($src - $range[0], $closestRangeStart);
                }
            }

            if(!$foundMappingRange){
                $len = min($closestRangeStart, $range[1]);
                $ranges[] = [$range[0], $len];
                $range[0] += $len;
                $range[1] -= $len;
            }
        }

        return $ranges;
    }

    function mapValue($map, $value) : int {
        foreach($map as $mapEntry){
            if($value >= $mapEntry[1] && $value < $mapEntry[1] + $mapEntry[2]){
                return ($value - $mapEntry[1]) + $mapEntry[0];
            }
        }

        return $value;
    }

    function buildMap($header) : array{
        $line = 0;
        $map = [];
        $line = gotoHeader($line, $header);
        // echo "Header at: " . $line . "\n";

        while($line < count($GLOBALS["input"]) && trim($GLOBALS["input"][$line]) != ""){
            // echo trim($GLOBALS["input"][$line]) . "\n";
            $map[] = array_map("intval", explode(" ", trim($GLOBALS["input"][$line])));
            $line++;
        }

        // echo "Map size: " . count($map) . "\n";

        return $map;
    }

    // Go to the line after the coresponding header
    function gotoHeader($line, $header): int{
        while(!str_starts_with($GLOBALS["input"][$line], $header) && $line < count($GLOBALS["input"])){
            $line++;
        }

        return $line+1;
    }
?>