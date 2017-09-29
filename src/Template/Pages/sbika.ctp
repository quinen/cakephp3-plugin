<?php

use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

function file2array($filename)
{
    $fc1 = new File($filename);
    $data1 = $fc1->read();
    $data1 = utf8_encode($data1);
    $data1Array = explode("\r\n", $data1);
    $array1 = collection($data1Array)->map(function ($line) {
        return explode("\t", $line);
    })->toArray();
    return $array1;
}

$folder = TMP;
$dir    = new Folder($folder);
$files  = $dir->find('.*\.(csv|txt)');

//debug($files);
/*
[
	(int) 0 => 'Fichier clients et prospects 2.txt',
	(int) 1 => 'Fichier clients et prospects.txt',
	(int) 2 => 'Marchandises.csv'
]
*/

$c1 = collection(file2array(TMP.DS."Fichier clients et prospects.txt"))->buffered();
$c2 = collection(file2array(TMP.DS."Fichier clients et prospects 2.txt"))->buffered();

$entetes = collection($c1->first())->append($c2->first())->toList();

// ajout des colonnes vides
$nb = 5;
// ->take($nb)
$list1  = $c1->skip(1)->map(function ($line) {
    $range = array_map(function ($col) {
        return null;
    }, range(24, 24+17));
    return $line + array_combine(range(24, 24+17), $range);
});
$list2  = $c2->skip(1)->map(function ($line) {
    // re-indexe les colonnes
    $range = range(0, 23);
    $range = array_map( function ($col) {
        return null;
    }, $range);
    return $range + array_combine(range(24, 24 + count($line)-1), array_values($line));
});

$array2 = [];

$all = collection([$entetes])->append($list1)->append($list2)->toList();
$some = collection($all)->take(10)->toArray();

/*
echo $this->Html->div('row',
    $this->Html->div('col-md-4', $this->Html->pre(var_export($list1->toList(), true))).
    $this->Html->div('col-md-4', $this->Html->pre(var_export($list2->toList(), true))).
    $this->Html->div('col-md-4', $this->Html->pre(var_export($all->toList(), true)))
);
*/
//debug($array1);debug($array2);
//*
//echo count($all);

echo $this->Html->table($some,[],[
    'title' => "toto"
]);

/*
    // ecriture du fichier texte dans le dossier tmp

$fcAll = new File(TMP."fusion.txt",true);
$fcAll->write(    implode(
    "\n", 
    collection($all)->map(function ($line) {
        return implode("\t",$line);
    })->toArray()
));
*/
