<?php

require_once(ROOT.DS."plugins".DS."Quinen".DS."src".DS."functions.php");

use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
if(is_null(ConnectionManager::getConfig('quinen'))){
   ConnectionManager::config('quinen', [
    //Configure::write('Datasources.quinen', [
        'className' => 'Cake\Database\Connection',
        'driver' => 'Cake\Database\Driver\Mysql',
        'persistent' => false,
        'host' => 'localhost',
        'username' => 'root',
        'password' => '5820',
        'database' => 'quinen',
        'encoding' => 'utf8',
        'timezone' => 'UTC',
        'cacheMetadata' => true,
    ]); 
}

