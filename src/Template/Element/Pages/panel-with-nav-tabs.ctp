<?php

$panelTabs = [
    [
        'tab'   => "Default 1",
        'content' => "Default 1"
    ],
    [
        'tab'   => "Default 2",
        'content' => "Default 2"
    ],
    [
        'tab'   => "Default 3",
        'content' => "Default 3"
    ],
    [
        'tab'   => "Dropdown",
        'menu'  => [
            [
                'tab'   => "Default 4",
                'content' => "Default 4"
            ],
            [
                'tab'   => "Default 5",
                'content' => "Default 5"
            ]
        ],
    ]
];

echo $this->Html->navTabs($panelTabs);
echo $this->Html->panelTabs($panelTabs);
/*


*/

?>
<hr/>
<div class="panel with-nav-tabs panel-default">
    <div class="panel-heading">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1default" data-toggle="tab" aria-expanded="true">Default 1</a></li>
                <li><a href="#tab2default" data-toggle="tab" aria-expanded="true">Default 2</a></li>
                <li><a href="#tab3default" data-toggle="tab" aria-expanded="true">Default 3</a></li>

                <li class="dropdown">
                    <a href="#" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#tab4default" data-toggle="tab" aria-expanded="true">Default 4</a></li>
                        <li><a href="#tab5default" data-toggle="tab" aria-expanded="true">Default 5</a></li>
                    </ul>
                </li>

            </ul>
    </div>
    <div class="panel-body">
        <div class="tab-content">
            <div class="tab-pane in active" id="tab1default">Default 1</div>
            <div class="tab-pane" id="tab2default">Default 2</div>
            <div class="tab-pane" id="tab3default">Default 3</div>
            <div class="tab-pane" id="tab4default">Default 4</div>
            <div class="tab-pane" id="tab5default">Default 5</div>
        </div>
    </div>
</div>
<hr/>
