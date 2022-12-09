# TLK LAN CODE COMPO


### OO PHP 

Part 2 is run with existing data for a more accurate approximation of the performance of the algorithm

### Specs for benchmarking
 - PHP 8.1.13
 - PHPBench 1.2.7
 - Ryzen Threadripper 2950X
 - 64GB DDR4 @ 3200Mhz
 - Gigabyte Designare X399
 - Opcache disabled
 - Xdebug disabled
 - 10 000 revs


| iter | benchmark   | subject    | set | revs  | mem_peak   | time_avg    | comp_z_value | comp_deviation |
|------|-------------|------------|-----|-------|------------|-------------|--------------|----------------|
| 0    | ParserBench | benchPart1 |     | 10000 | 1,292,416b | 6,009.641μs | 0.00σ        | 0.00%          |
| 0    | ParserBench | benchPart2 |     | 10000 | 940,952b   | 1,390.457μs | 0.00σ        | 0.00%          |

![image](https://user-images.githubusercontent.com/30026633/206765449-30a7f5bd-49f8-4ca3-9687-73ef1fc4cb6e.png)
