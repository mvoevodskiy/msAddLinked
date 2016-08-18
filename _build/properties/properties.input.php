<?php

$properties = array();

$tmp = array(
	'tpl' => array(
		'type' => 'textfield',
		'value' => 'tpl.msAddLinked.input',
	),
	'product' => array(
		'type' => 'textfield',
		'value' => '0',
	),
	'link' => array(
		'type' => 'textfield',
		'value' => '0',
	),
	'inputType' => array(
		'type' => 'textfield',
		'value' => 'checkbox',
	),
	'priceTarget' => array(
		'type' => 'textfield',
		'value' => '#price',
	),
	'priceOrigTarget' => array(
		'type' => 'textfield',
		'value' => '#msal_price_original',
	),
	'priceFullTarget' => array(
		'type' => 'textfield',
		'value' => '#msal_price_full',
	),
	'fieldName' => array(
		'type' => 'textfield',
		'value' => "pagetitle",
	),
	'fieldDiscount' => array(
		'type' => 'textfield',
		'value' => "",
	),
	'toPlaceholder' => array(
		'type' => 'combo-boolean',
		'value' => false,
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