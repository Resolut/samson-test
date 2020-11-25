<?php

function findSimple($a, $b)
{
    $array = [];

    for ($num = $a; $num <= $b; $num++) {
        if ($num < 2) continue;
        if ($num == 2) $array[] = $num;
        if ($num % 2 == 0) continue;

        $isSimple = true; // флаг для определения, что число простое

        /* чётные числа проверять излишне.
         * проверка всех делителей меньших или равных квадратному корню числа
         * */
        for ($i = 3; $i * $i <= $num; $i += 2) {
            if ($num % $i == 0) {
                $isSimple = false;
                break;
            }
        }

        if ($isSimple) $array[] = $num;
    }

    return $array;
}

function createTrapeze($a)
{
    $array = [];
    $subArray = [];

    for ($i = 0, $size = count($a); $i < $size; $i++) {
        if ($i % 3 == 0) {
            $subArray['a'] = $a[$i];
        }
        if ($i % 3 == 1) {
            $subArray['b'] = $a[$i];
        }
        if ($i % 3 == 2) {
            $subArray['c'] = $a[$i];
            $array[] = $subArray;
            $subArray = [];         // "обнуление" массива для следующей итерации
        }
    }

    return $array;
}

function squareTrapeze($a)
{
    for ($i = 0, $size = count($a); $i < $size; ++$i) {
        $a[$i]['s'] = ($a[$i]['a'] + $a[$i]['b']) / 2 * $a[$i]['c'];
    }

    return $a;
}

function getSizeForLimit($a, $b)
{
    for ($i = 0, $size = count($a); $i < $size; ++$i) {
        if ($a[$i]['s'] > $b) {
            unset($a[$i]);
        }
    }

    return $a;
}

function getMin($a)
{
    $min = null;

    // определение ассоциативности массива и исполнение соответствующего цикла для перебора
    if (array_keys($a) !== range(0, count($a) - 1)) {
        foreach ($a as $key => $value) {
            if ($value < $min or $min === null) {
                $min = $value;
            }
        }
    } else {
        foreach ($a as $value) {
            if ($value < $min or $min === null) {
                $min = $value;
            }
        }
    }

    return $min;
}

function printTrapeze($a)
{
    // добавление стилей таблице и заголовочной строке для визуального улучшения
    print "<table style='border:1px solid;border-collapse:collapse;'>\n";
    print "<tr style='color:white;background-color:darkcyan;'>";

    foreach (array_keys($a[0]) as $key) {
        print "<th style='padding: 4px;'>$key</th>";
    }

    print "</tr>\n";

    foreach ($a as $subArray) {
        // выделение строк с нечётной площадью с помощью стилей
        if ($subArray['s'] % 2 == 1) {
            print "<tr style='background: slategrey'>";
        } else {
            print "<tr>";
        }

        foreach ($subArray as $key => $value) {
            print "<td style='border: 1px solid;padding: 8px;'>$value</td>";
        }

        print "</tr>\n";
    }

    print '</table>';
}

abstract class BaseMath
{
    protected function exp1($a, $b, $c)
    {
        return $a * ($b ** $c);
    }

    protected function exp2($a, $b, $c)
    {
        return ($a / $b) ** $c;
    }

    abstract protected function getValue(); // метод обязательно должен быть определён в наследнике
}

class F1 extends BaseMath
{
    private $f = 1;

    public function __construct($a, $b, $c)
    {
        $this->f = $this->exp1($a, $b, $c) + (($this->exp2($a, $c, $b) % 3) ** getMin([$a, $b, $c]));
    }

    public function getValue()
    {
        return $this->f;
    }
}
