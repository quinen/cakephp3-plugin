<?php
/* @var $this \Cake\View\View */
$menu = [
    [
        'brand' => "Quinen.net",
        "link" => "/quinen",
        'icon' => "home"

    ],
    [
        'content' => "Utilisateurs",
        'menu' => [
            [
                'content' => "Groupes",
                'link' => [
                    'plugin' => "Quinen",
                    'controller' => "QnnGrpGroups",
                ]

            ]
        ] 
    ],
    [
        'content' => 'Tests',
        'link' => "quinen/pages",
        'icon' => "file"
    ]
];

echo $this->Html->navbar($menu,[
    'type' => "inverse",
    'isStaticTop' => true
]);