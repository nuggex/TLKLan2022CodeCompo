<?php


class Parser
{
    private $file;
    private $filename;

    public function __construct()
    {
        $this->filename = dirname(__FILE__) . "/i.txt";
        $this->file = file($this->filename, FILE_IGNORE_NEW_LINES);
    }

    public function part1()
    {
        $realRooms = array();
        $returnRooms = array();
        foreach ($this->file as $row) {
            $unique = [];
            $split = explode("[", $row);
            $checksum = explode("]", $split[1])[0];
            $unique = array_fill_keys(array_values(array_unique(str_split(preg_replace('~[^\p{M}\p{L}]+~u', '', $split[0])))), "0");
            $roomNumber = preg_replace('/\D/', '', $split[0]);
            $replace = preg_replace('~[^\p{M}\p{L}]+~u', '', $split[0]);
            foreach (count_chars($replace, 1) as $i => $val) {
                $unique[chr($i)] = $val;
            }
            ksort($unique);
            arsort($unique);
            $keys = array_keys($unique);
            $crypt = $keys[0] . $keys[1] . $keys[2] . $keys[3] . $keys[4];
            if ($crypt == $checksum) {
                $realRooms[] = $roomNumber;
                $returnRooms[] = array($split[0], $roomNumber);
            }
        }
        print_r("Sum of realRooms: " . array_sum($realRooms) . "\n");
        return $returnRooms;
    }

    public function part2()
    {
        $realRooms = $this->part1();
        foreach ($realRooms as $row) {
            $exploded = str_split($row[0]);
            foreach ($exploded as $key => $expl) {
                $char = ord($expl);
                for ($i = 0; $i < $row[1]; $i++) {
                    if ($char == 122) {
                        $char = 97;
                    } elseif ($char == 45) {
                        $char = ord(" ");
                    } elseif ($char > 45) {
                        $char += 1;
                    }
                }
                $exploded[$key] = chr($char);
            }
            $string = implode($exploded);
            if (str_contains($string, "north")) {
                print_r($string . "\n");
                print_r($row[1] . "\n");
                exit;
            }
        }
    }
}