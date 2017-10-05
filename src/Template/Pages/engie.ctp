<?php

use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

/*
    convertit un fichier en un tableau de données
*/
function file2array($filename, array $options = [])
{
    $options += [
        'isUtf8Encode'  => true,
        'separator'     => "\t",
        'newLine'       => "\r\n"
    ];

    $fc1 = new File($filename);
    $data1 = $fc1->read();
    // est ce qu'on encode le texte en utf8 ?
    if ($options['isUtf8Encode']) {
        $data1 = utf8_encode($data1);
    }

    $data1Array = explode($options['newLine'], $data1);
    $array1 = collection($data1Array)->map(function ($line) use ($options) {
        return explode($options['separator'], $line);
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
$apps = collection(file2array(TMP.DS."engie-apps.txt"))->buffered()->toArray();
echo $this->Html->table($apps, [], ['title' => "toto"]);

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
