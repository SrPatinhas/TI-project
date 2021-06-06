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

function dump($text) {

    echo "<pre>";
    print_r($text);
    echo "</pre>";
    die();
    return false;
}

function chart_format($list) {
    $datasets = [];
    $labels = [];

    foreach ($list as $item) {
        $labels[] = $item["date"];
        $datasets[] = $item["value"];
    }

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