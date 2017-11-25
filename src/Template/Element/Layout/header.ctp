<?php

$menu = [
    [
        'brand' => "Quinen.net",
        "link" => "/quinen",
        'icon' => "home"

    ],
    [
        'content' => 'Pages',
        'link' => "quinen/pages",
        'icon' => "file"
    ]
];

echo $this->Html->navbar($menu,[
    'type' => "inverse",
    'isStaticTop' => true
]);