<?php

$settings = array();

$tmp = array(
	'msal_frontend_js' => array(
		'value' => '[[+jsUrl]]web/default.js'
		,'xtype' => 'textfield'
		,'area' => 'msal_main'
	),
	'msal_variable' => array(
		'value' => 'msal'
		,'xtype' => 'textfield'
		,'area' => 'msal_main'
	),
);

foreach ($tmp as $k => $v) {
	/* @var modSystemSetting $setting */
	$setting = $modx->newObject('modSystemSetting');
	$setting->fromArray(array_merge(
		array(
			'key' => '' . $k,
			'namespace' => PKG_NAME_LOWER,
		), $v
	), '', true, true);

	$settings[] = $setting;
}

unset($tmp);
return $settings;
