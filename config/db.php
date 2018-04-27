<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'oci:dbname=172.18.1.10/stidsv;charset=UTF8',
    'username' => 'SAESP',
    'password' => '123S.E.N.H.A.321',
    'attributes' => [PDO::ATTR_CASE => PDO::CASE_LOWER],
    'charset' => 'utf8',
    'on afterOpen'=>function($event){
    	$event->sender->createCommand("ALTER SESSION SET NLS_NUMERIC_CHARACTERS = ',.'")->execute();
        $event->sender->createCommand("ALTER SESSION SET NLS_DATE_FORMAT = 'DD/MM/YYYY'")->execute();
        $event->sender->createCommand("ALTER SESSION SET NLS_SORT = WEST_EUROPEAN")->execute();
    },
    // Schema cache options (for production environment)
    'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
