<?php
// liste les pages dans le dossier
$folder = ROOT.DS."plugins".DS."Quinen".DS."src".DS."Template".DS."Element".DS.$this->name;
$dir    = new Cake\Filesystem\Folder($folder);
$files  = $dir->find('.*\.ctp');

// genere le tableau equivalent pour afficher les elements
$navTabs = collection($files)->map(function ($file) {
    $name = str_replace(".ctp", "", $file);
    return [
        'tab'       => ucwords($name),
        'content'   => $this->element($this->name."/".$name)
    ];
})->toArray();

// genere les tabs correspondants
echo $this->Html->navTabs($navTabs);



  


