<?php

$months = array('jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec');

$stats = array();

$page = 1;
while (true) {
    $url = 'http://rosalind.info/problems/dna/recent/?page=' . $page;
    $text = @file_get_contents($url);
    if (empty($text)) {
        break;
    }
    
    $matches = array();
    preg_match_all('/href\=\"\/users\/([^\/]+)\/.+?\<td\>([^\<]+)/s', $text, $matches, PREG_SET_ORDER);
    foreach ($matches as $m) {
        $x = array();
        preg_match('/(\S+).+?(\d{4})/', $m[2], $x);
        $month = $x[2] . '-' . base_convert('' . array_search(substr(strtolower($x[1]), 0, 3), $months), 10, 16);
        if (!isset($stats[$month])) {
            $stats[$month] = 0;
        }
        $stats[$month] += 1;
    }
    echo "page $page\n";
    $page += 1;
}

echo "\n";

ksort($stats);
foreach ($stats as $m => $cnt) {
    echo "$m,$cnt\n";
}
