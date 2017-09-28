<?php

$html = "";

// list all the icon inside the css file
// get the file
$file = file_get_contents("https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css");

$icons = [];
// parse regex /.glyphicon-(.*):/
if (preg_match_all("/.fa-([^:]*):before/", $file, $m)) {
    // store in a an array all the icons
    $icons = $m[1];
} else {
    $html .= "nothing found";
}
sort($icons);
$html .= implode("\n",collection($icons)->map(function ($v) {
    return $this->Html->fa($v, ['size'=>'lg','title'=>$v,'spaceAfter'=>true]);
})->toArray());

echo $html;