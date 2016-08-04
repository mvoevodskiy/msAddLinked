<?php
/** @noinspection PhpIncludeInspection */
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CONNECTORS_PATH . 'index.php';
/** @var msAddLinked $msAddLinked */
$msAddLinked = $modx->getService('msaddlinked', 'msAddLinked', $modx->getOption('msaddlinked_core_path', null, $modx->getOption('core_path') . 'components/msaddlinked/') . 'model/msaddlinked/');
$modx->lexicon->load('msaddlinked:default');

// handle request
$corePath = $modx->getOption('msaddlinked_core_path', null, $modx->getOption('core_path') . 'components/msaddlinked/');
$path = $modx->getOption('processorsPath', $msAddLinked->config, $corePath . 'processors/');
$modx->request->handleRequest(array(
	'processors_path' => $path,
	'location' => '',
));