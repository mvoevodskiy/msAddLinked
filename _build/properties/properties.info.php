<?php

$properties = array();

$tmp = array(
	'tpl' => array(
		'type' => 'textfield',
		'value' => 'tpl.msAddLinked.info',
	),
	'option' => array(
		'type' => 'textfield',
		'value' => '{}',
	),
	'fieldName' => array(
		'type' => 'textfield',
		'value' => "pagetitle",
	),
);

foreach ($tmp as $k => $v) {
	$properties[] = array_merge(
		array(
			'name' => $k,
			'desc' => PKG_NAME_LOWER . '_prop_' . $k,
			'lexicon' => PKG_NAME_LOWER . ':properties',
		), $v
	);
}

return $properties;