<?php


class Parser
{
    private array $file;
    private string $filename;
    private int $sumOfRooms;
    private array $returnRooms;

    function __construct()
    {
        $this->filename = dirname(__FILE__) . "/i.txt";
        $this->file = file($this->filename, FILE_IGNORE_NEW_LINES);
    }

    public function part1(): array
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
            // Get room number from string by replaceing all non digit characters
            $roomNumber = preg_replace('/\D/', '', $split[0]);
            // if keys of top 5 items in unique after sorting is equal to split then it is a real room
            $checkString = implode(array_slice(array_keys($unique), 0, 5));
            if (str_contains($split[1], $checkString)) {
                $realRoomNumbers[] = $roomNumber;
                $returnRooms[] = array($split[0], $roomNumber);
            }
        }
        // Set sum of rooms and returnRooms to be used in Part 2
        $this->sumOfRooms = array_sum($realRoomNumbers);
        $this->returnRooms = $returnRooms;
        return $returnRooms;
    }

    public function part2(): bool|array
    {
        // Check if realRooms is set in instance
        if (!$realRooms = $this->returnRooms) {
            $realRooms = $this->part1();
        }
        // loop through the items
        foreach ($realRooms as $row) {
            // Explode to individual characters
            $exploded = str_split($row[0]);
            $res = [];
            foreach ($exploded as $character) {
                // Get the numerical representation of the character
                $char = ord($character);

                // If the ord for the character is 45 it is "-" and should be replaced with " "
                if ($char === 45) {
                    $char = 32;
                    // If the character is between or equal to 122 and 97 it is a character we should translate
                } elseif ($char <= 122 && $char >= 97) {
                    // calculate the offset for the character with modulo
                    $mod = $row[1] % 26;
                    $char = $char + $mod;
                    // If the resulting character is above 122 we need to offset it to be in the span 97-122 (a-z)
                    if ($char > 122) {
                        $char = $char - 26;
                    }
                }
                // Insert the character back into the place where we got it
                $res[] = chr($char);
            }
            $string = implode($res);
            // If the string contains the word north it is the string we are looking for
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