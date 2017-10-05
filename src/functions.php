<?php

use Cake\Utility\Hash;

function dbbt(){

    $dbbt = collection(debug_backtrace())->map(function($trace,$index){
        if($index)
        {
            // object, class, type, function, file, line, args
            unset($trace['object']);

            $string = $trace['function']."(".count($trace['args'])."):".$trace['line'];

            if(isset($trace['class'])){
                $string = $trace['class'].$trace['type'].$string;
            }
            return $string;
        }
    })->skip(1)->take(3)->toArray();

    debug($dbbt);
}