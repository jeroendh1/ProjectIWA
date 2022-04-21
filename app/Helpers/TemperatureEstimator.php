<?php

namespace App\Helpers;

use http\Exception\InvalidArgumentException;

class TemperatureEstimator
{
    private float $a;
    private float $b;

    public function __construct(array $x, array $y)
    {
        $n = count($x);
        $xSum = array_sum($x);
        $ySum = array_sum($y);
        $xAvg = $xSum / $n;
        $yAvg = $ySum / $n;

        $n1 = array_sum(array_map(function($i) use ($x, $y) { return $x[$i] * $y[$i]; }, range(0, $n - 1)));
        $n2 = $xSum * $ySum;
        $numerator = $n1 - $n2;

        $d1 = array_sum(array_map(function($i) use ($x) { return $x[$i] * $x[$i]; }, range(0, $n - 1)));
        $d2 = $xSum * $xSum;
        $denominator = $d1 - $d2;

        $this->b = $numerator / $denominator;
        $this->a = $yAvg - $this->b * $xAvg;
    }

    public function estimate(int $x): float
    {
        return $this->a + $this->b * $x;
    }
}
