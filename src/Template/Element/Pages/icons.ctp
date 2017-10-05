<?php

// list all the icon inside the css file
function getIcons($url, $regex)
{
    // get the file
    $file = file_get_contents($url);
    
    $icons = [];
    // parse regex /.glyphicon-(.*):/
    if (preg_match_all($regex, $file, $m)) {
        // store in a an array all the icons
        $icons = $m[1];
    } else {
        $html .= "nothing found";
    }
    sort($icons);
    return $icons;
}

$fas = getIcons("https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css", "/.fa-([^:]*):before/");
$gis = getIcons("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css", "/.glyphicon-([^:]*):before/");
$intersect = array_intersect($fas, $gis);
$fas = array_diff($fas, $intersect);
$gis = array_diff($gis, $intersect);


$htmlFa = implode("\n", collection($fas)->map(function ($v) {
    return $this->Html->fa($v, ['size'=>2,'title'=>$v,'spaceAfter'=>true]);
})->toArray());

$htmlGi = implode("\n", collection($gis)->map(function ($v) {
    return $this->Html->gi($v, ['size'=>2,'title'=>$v,'spaceAfter'=>true]);
})->toArray());

$htmlIntersect = implode("\n", collection($intersect)->chunk(2)->map(function ($v) {
    return $this->Html->row(
        collection($v)->map(function ($v) {
            return [
                $this->Html->gi($v, ['size'=>2,'title'=>$v,'spaceAfter'=>true]),
                $this->Html->fa($v, ['size'=>2,'title'=>$v,'spaceAfter'=>true]),
                $this->Html->div('text-nowrap', $v)
            ];
        })->unfold()->toArray(),
        [
            'width' => [1,1,4,1,1,4]
        ]
    );
})->toArray());



echo $this->Html->row([$htmlFa,$htmlGi,$htmlIntersect]);
