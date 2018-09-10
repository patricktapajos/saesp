<?php
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'language' => 'pt-br',
    'name'=>'SAESP - Sistema de Atividades Esportivas',
    'timeZone' => 'America/Manaus',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@upload'   => '@app/web/upload',
        '@images'   => '@app/web/images',
    ],
    'modules'=>[
        'coordenador' => [
            'class' => 'app\modules\coordenador\Coordenador',
        ],
        'professor' => [
            'class' => 'app\modules\professor\Professor',
        ],
        'inscricao' => [
            'class' => 'app\modules\inscricao\Inscricao',
        ],
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'xZoZWeuvXp77Wpp877JaDe5xY3lFBAIO',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]

        ],
        'response' => [
            'formatters' => [
                \yii\web\Response::FORMAT_JSON => [
                    'class' => 'yii\web\JsonResponseFormatter',
                    'prettyPrint' => YII_DEBUG, // use "pretty" output in debug mode
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ],
            ],
        ],
        'authManager'=>[
            'class'=>'app\components\rbac\SAESPAuthManager'
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'defaultTimeZone' => 'America/Manaus',
            'dateFormat' => 'php:d/m/Y',
            'datetimeFormat' => 'php:d/m/Y H:i:s',
            'timeFormat' => 'php:H:i:s',
            'decimalSeparator' => ',',
            'thousandSeparator' => '.',
            'currencyCode' => 'R$',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            //'viewPath' => '@app/mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => env('EMAIL_HOST'),
                'username' => env('EMAIL_USER'),
                'password' => env('EMAIL_PASS'),
                'port' => '25',
                //'encryption' => 'tls',
            ],
        ],
        'pdf' => [
            'class' => kartik\mpdf\Pdf::classname(),
            'format' => kartik\mpdf\Pdf::FORMAT_A4,
            'orientation' => kartik\mpdf\Pdf::ORIENT_PORTRAIT,
            'destination' => kartik\mpdf\Pdf::DEST_BROWSER,
            'mode' => kartik\mpdf\Pdf::MODE_CORE, 
            // refer settings section for all configuration options
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        //'db'=>require(__DIR__ . '/../../sdb/saesp.php'),
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            //'enableStrictParsing' => true,
            /*'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => 'rest'],
            ],*/
        ],
    ],
    'params' => $params,
];

if (env('YII_ENV_DEV')) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
