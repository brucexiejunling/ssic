<?php
	return array(
		//'配置项'=>'配置值'

		'DB_type' => 'mysql',
		'DB_HOST' => 'localhost',
		'DB_NAME' => 'innovation_contest',
		'DB_USER' => 'root',
		'DB_PWD' => '123900',
		'DB_PORT' => 3306,
		'DB_PREFIX' => 'ic_',
		
		'TRACE_PAGE_TABS' => array(
			'base' => 'base',
			'file' => 'file',
			'think' => 'think',
			'error' => 'error',
			'sql' => 'sql',
			'debug' => 'debug',
		),
		'PAGE_TRACE_SAVE' => true,


		'TMPL_PARSE_STRING' => array(
			'__PUBLIC__' => '/innovation_contest/Public',
			'__CSS__' => '/innovation_contest/Public/css',
			'__JS__' => '/innovation_contest/Public/js',
			'__IMG__' => '/innovation_contest/Public/img',
			'__UPLOAD__' => '/innovation_contest/Upload',
			'__ROOT__' => '/innovation_contest',
		),

		'URL_MODEL' => 2 
	);
?>