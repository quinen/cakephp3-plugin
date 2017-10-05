<?php

$table = [
    [
        'Model' => [
            'champ' => "valeur de champ"
        ]
    ],
    [
        'Model' => [
            'champ' => "valeur de champ 2",
            'int'   => 55
        ]
    ],
    [
        'Model' => [
            'champ'     => "valeur de champ 3",
            'int'       => 56,
            'tableau'   => ["un","deux"=>2,3]
        ]
    ],
];
$map = [
    "Model.champ"
    ,[
        'label' => $this->Html->fa('sort-numeric-asc')."numerique",
        'field' => "Model.int"
    ]
    //*
    ,[
        'label'     => $this->Html->fa('list')."liste",
        'field'     => "Model.tableau",
        'format'    => "json_encode"
    ]
    //*/
    ///*
    ,[
        'label'     => $this->Html->fa('list')."liste",
        'field'     => "Model.tableau",
        'format'    => [$this->Html,"ul"]
    ]
    //*/
    ,[
        'label' => $this->Html->fa('question')."champ inexistant",
        'field' => "Model.toto"
    ]
    ,[
        'field' => "Model.champ"
    ]
];

$map2print = Cake\Utility\Hash::insert($map,'3.format',["\$this->Html","ul"]);

echo $this->Html->row([
    $this->Html->pre($table),
    $this->Html->pre($map2print)
]);
echo $this->Html->table($table, [], [
    'title' => "Titre de mon tableau",
    'type'  => "primary"
]);
echo $this->Html->table($table, $map);
