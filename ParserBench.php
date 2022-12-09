<?php


require_once "Parser.php";

class ParserBench
{
    public Parser $Parser;

    public function __construct()
    {
        $this->Parser = new Parser();
    }

    public function benchPart1()
    {
        $this->Parser->part1();
    }

    public function benchPart2()
    {
        $this->Parser->part2();
    }
}
