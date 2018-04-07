<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
	'id' => 'test.zp',
	'basePath' => dirname(__DIR__),
	'bootstrap' => ['log'],
	'controllerNamespace' => 'app\\commands',
	'aliases' => [
		'@bower' => '@vendor/bower-asset',
		'@npm'   => '@vendor/npm-asset',
	],
	'components' => [
		'zpClient' => [
			'class' => app\models\ZpClient::class,
			'url' => 'https://api.zp.ru/v1/vacancies?geo_id=826&period=today',
		],
		'log' => [
			'targets' => [
				[
					'class' => yii\log\FileTarget::class,
					'levels' => ['info', 'error', 'warning'],
				],
			],
		],
		'db' => $db,
	],
	'params' => $params,
];

if (YII_ENV_DEV) {
	$config['bootstrap'][] = 'gii';
	$config['modules']['gii'] = [
		'class' => yii\gii\Module::class,
	];
}

return $config;