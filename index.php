<?php
use Src\Parser;
require __DIR__.'/vendor/autoload.php';
$sitemap_url = '';
$new_domain = '';
$old_domain = '';
$to_html = true;
//Leave $output value empty to show result on screen or enter path to file where to save result
$output = '';
$data = new Parser($sitemap_url,$old_domain,$new_domain,$output,$to_html);