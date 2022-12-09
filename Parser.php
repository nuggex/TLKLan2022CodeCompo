<?php


class Parser
{
    private $file;
    private $filename;
    private $sumOfRooms;

    public function __construct()
    {
        $this->filename = dirname(__FILE__) . "/i.txt";
        $this->file = file($this->filename, FILE_IGNORE_NEW_LINES);

    }

    public function part1()
    {
        $realRoomNumbers = array();
        $returnRooms = array();
        // Loop through every row
        foreach ($this->file as $row) {
            $unique = [];
            $split = explode("[", $row);
            $unique = array_fill_keys(array_unique(str_split(preg_replace('~[^\p{M}\p{L}]+~u', '', $split[0]))), "0");
            $replace = preg_replace('~[^\p{M}\p{L}]+~u', '', $split[0]);
            // Count characters in string and set counts in unique array
            foreach (count_chars($replace, 1) as $i => $val) {
                $unique[chr($i)] = $val;
            }

            // Sort unique array first by keys and then by values reversed
            ksort($unique);
            arsort($unique);
            // Get keys from unique array
            $keys = array_keys($unique);
            // Get room number from string by replaceing all non digit characters
            $roomNumber = preg_replace('/\D/', '', $split[0]);
            // if keys of top 5 items in unique after sorting is equal to split then it is a real room
            $checkString = $keys[0] . $keys[1] . $keys[2] . $keys[3] . $keys[4];
            if (str_contains($split[1], $checkString)) {
                $realRoomNumbers[] = $roomNumber;
                $returnRooms[] = array($split[0], $roomNumber);
            }
        }
        $this->sumOfRooms = array_sum($realRoomNumbers);
        return $returnRooms;
    }

    public function part2()
    {
        $realRooms = $this->part1();
        foreach ($realRooms as $row) {
            $exploded = str_split($row[0]);
            foreach ($exploded as $key => $character) {
                $char = ord($character);
                if ($char === 45) {
                    $char = 32;
                } elseif ($char <= 122 && $char >= 97) {
                    $mod = $row[1] % 26;
                    $char = $char + $mod;
                    if ($char > 122) {
                        $char = $char - 26;
                    }
                }
                $exploded[$key] = chr($char);
            }
            $string = implode($exploded);
            if (str_contains($string, "north")) {
                return array("Name" => $string, "Roomnumber" => $row[1]);
            }
        }
        return false;
    }

    public function run()
    {
        $this->part1();
        print_r("Sum of real rooms: " . $this->sumOfRooms . "\n");
        var_dump($this->part2());
    }
}