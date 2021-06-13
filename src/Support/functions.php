<?php
/**
 * Created by PhpStorm.
 * Project: TI
 * User: Miguel Cerejo
 * Date: 4/25/2021
 * Time: 6:42 PM
 *
 * File: functions.php
 */

/**
 * Convert all applicable characters to HTML entities.
 *
 * @param string|null $text The string
 *
 * @return string The html encoded string
 */
function html(string $text = null): string
{
    return htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
/*
 * returns the given data, mostly used to do some debug
 */
function dump($text) {

    echo "<pre>";
    print_r($text);
    echo "</pre>";
    die();
    return false;
}
/*
 * converts a given list of logs to the required format of the ChartJs array list
 */
function chart_format($list) {
    $datasets = [];
    $labels = [];
    // gets 2 lists, one with the labels, and the other with the data for the graphic
    foreach ($list as $item) {
        $labels[] = $item["date"];
        $datasets[] = $item["value"];
    }
    //required object for the ChartJs library
    $info = [
        "label" => "Device values",
        "data" => $datasets,
        "borderWidth" => 3,
        "fill" => false,
        "pointRadius" => 0,
        "pointHoverRadius" => 0,
        "lineTension" => 0.5,
        "backgroundColor" => 'transparent',
        "borderColor" => '#007bff',
        "pointBackgroundColor" => '#007bff'
    ];

    return ["list" => $info, "label" => $labels];
}