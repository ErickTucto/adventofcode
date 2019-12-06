<?php

$lines = file(__DIR__.'/input.txt', FILE_IGNORE_NEW_LINES);

$input1 = $lines[0];
$input2 = $lines[1];

function convertCoords(string $input): array
{
    preg_match_all("/([R,L,D,U])(\d+),*/", $input, $array, PREG_SET_ORDER);

    return array_map(function ($coord) {
        $number = in_array($coord[1], ['L', 'D']) ? -((int) $coord[2]) : (int) $coord[2];
        $dir = in_array($coord[1], ['L', 'R']) ? 'x' : 'y';
        return [
            "dir" => $dir,
            "steps" => $number,
        ];
    }, $array);
}

$cable1 = convertCoords($input1);
$cable2 = convertCoords($input2);

function restar($number) {
    return ($number <=> 0) * (abs($number) - 1);
}

function run($x, $y, $dir, $step)
{
    $acumulador = [];
    if ($step == 0) {
        return [];
    }
    if ($dir == 'y') {
        $y = $y + ($step <=> 0);
    } elseif ($dir == 'x') {
        $x = $x + ($step <=> 0);
    }
    $acumulador[] = "{$x},{$y}";
    $step = restar($step);
    return array_merge(
        $acumulador,
        run($x, $y, $dir, $step)
    );
}

function getTrack(array $cable, array $find = [])
{
    $track = [];
    $steps = [];
    $x = 0;
    $y = 0;
    $s = 0;
    foreach ($cable as $c) {
        $run = run($x, $y, $c['dir'], $c['steps']);
        $track = array_merge(
            $track,
            $run
        );
        if (count($find) > 0) {
            $finded = array_intersect($run, $find);
            if (count($finded) > 0) {
                foreach ($finded as $f) {
                    $key = array_search($f, $finded);
                    $steps[$f] = $s + $key + 1;
                }
            }
            $s = $s + abs($c["steps"]);
        }
        [$x, $y] = explode(",", end($track));
    }
    return [
        "track" => $track,
        "steps" => $steps
    ];
}

$tracking1 = getTrack($cable1);
$tracking2 = getTrack($cable2);
$coords = array_intersect($tracking1["track"], $tracking2["track"]);
$tracking1 = getTrack($cable1, $coords);
$tracking2 = getTrack($cable2, $coords);

$result = [];
$steps1 = $tracking1["steps"];
$steps2 = $tracking2["steps"];

foreach ($coords as $coord) {
    $result[$coord] = $steps1[$coord] + $steps2[$coord];
}

print(min($result));