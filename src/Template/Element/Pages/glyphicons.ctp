<?php

$html = "";

// list all the icon inside the css file
// get the file
$file = file_get_contents("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css");

$icons = [];
// parse regex /.glyphicon-(.*):/
if (preg_match_all("/.glyphicon-([^:]*):before/", $file, $m)) {
    // store in a an array all the icons
    $icons = $m[1];
} else {
    $html .= "nothing found";
}

$html .= implode("\n",collection($icons)->map(function ($v) {
    return $this->Html->icon($v, ['size'=>2,'title'=>$v,'spaceAfter'=>true]);
})->toArray());

echo $this->Html->div('container',$this->Html->div('row',$html));