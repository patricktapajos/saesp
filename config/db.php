<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => env('DB_HOST'),
    'username' => env('DB_USER'),
    'password' => env('DB_PASS'),
    //'attributes' => [PDO::ATTR_CASE => PDO::CASE_LOWER],
    'charset' => 'utf8',
    'on afterOpen'=>function($event){
    	$event->sender->createCommand("ALTER SESSION SET NLS_NUMERIC_CHARACTERS = ',.'")->execute();
        $event->sender->createCommand("ALTER SESSION SET NLS_DATE_FORMAT = 'DD/MM/YYYY'")->execute();
        $event->sender->createCommand("ALTER SESSION SET NLS_SORT = WEST_EUROPEAN")->execute();
        $event->sender->createCommand("alter session set nls_comp=linguistic")->execute();
        $event->sender->createCommand("alter session set nls_sort=binary_ai")->execute();
    },
    // Schema cache options (for production environment)
    'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
