<?php

/** @var array $scriptProperties */
$tpl = $modx->getOption('tpl', $scriptProperties, 'tpl.msAddLinked.info');
$option = $modx->getOption('option', $scriptProperties, '{}');
$field_name = $modx->getOption('fieldName', $scriptProperties, 'pagetitle');
$output = '';

$pdoFetch = $modx->getService('pdoFetch');
$modx->lexicon->load('msaddlinked:default');

$links = json_decode($option, true);

if (!empty($links)) {
    foreach ($links as $linked => $count) {
        $linked = explode('__', $linked);
        if ($linkedMSP = $modx->getObject('msProduct', (int) $linked[0])) {
            if (((int) $count) <= 1) {
                $count = 1;
            }
            $linksOutput[] = array(
                "linked_id" => $linked[0],
                "linked_name" => $linkedMSP->get($field_name),
                "linked_price" => $linkedMSP->get('price'),
                "linked_count" => $count,
                "link_id" => $linked[1],
                "field_name" => $field_name,
                "value" => '',
            );
        }

    }

    if (!empty($linksOutput)) {
        $output = $pdoFetch->getChunk($tpl, array("links" => $linksOutput), true);
    }
    return $output;
}