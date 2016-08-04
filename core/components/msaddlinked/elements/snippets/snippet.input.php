<?php
/** @var array $scriptProperties */
/** @var msAddLinked $msAddLinked */
if (!$msAddLinked = $modx->getService('msaddlinked', 'msAddLinked', $modx->getOption('msaddlinked_core_path', null, $modx->getOption('core_path') . 'components/msaddlinked/') . 'model/msaddlinked/', $scriptProperties)) {
	return 'Could not load msAddLinked class!';
}
/** @var pdoFetch $pdoFetch */
$pdoFetch = $modx->getService('pdoFetch');

$tpl = $modx->getOption('tpl', $scriptProperties, 'tpl.msAddLinked.input');
//$tplOuter = $modx->getOption('tplOuter', $scriptProperties, 'tpl.msAddLinked.inputOuter');
$product_id = $modx->getOption('product', $scriptProperties, 0);
$link_id = $modx->getOption('link', $scriptProperties, 0);
$input_type = $modx->getOption('inputType', $scriptProperties, 'checkbox');
$field_name = $modx->getOption('fieldName', $scriptProperties, 'pagetitle');
$priceTarget = $modx->getOption('priceTarget', $scriptProperties, '#price');
$priceOrigTarget = $modx->getOption('priceOrigTarget', $scriptProperties, '#msal_price_original');
$toPlaceholder = $modx->getOption('toPlaceholder', $scriptProperties, false);

$var = $modx->getOption('msal_variable', null, 'msal');
$price = 0;
$output = '';

$product_id = $product_id == 0 ? $modx->resource->id : $product_id;

if ($product = $modx->getObject('msProduct', (int) $product_id)) {
    $price = $product->get('price');
} else return;

$criteria = array('master' => $product_id);
if (!is_numeric($link_id)) {
    if ($link = $modx->getObject('msLink', array('name' => $link_id ))) {
        $link_id = $link->get('id');
    } else {
        $link = 0;
    }
};
if ($link_id) {
    $criteria['link'] = $link_id;
}


/** @var msProductLink[] $rows */
$links = $modx->getCollection('msProductLink', $criteria);
$inputs = array();
foreach ($links as $l) {
    /** @var msProduct $linked */
    if ($linked = $l->getOne('Slave')) {
        if ($input_type != 'radio') {
            $value = '';
            $id = $linked->get('id');
        } else {
            $id = 'radio';
            $value = $linked->get('id');
        }
        $inputs[] = array(
            "linked_id" => $id,
            "linked_name" => $linked->get($field_name),
            "linked_price" => $linked->get('price'),
            "link_id" => $l->get('link'),
            "field_name" => $field_name,
            "input_type" => $input_type,
            "value" => $value,
        );
    }
}
if (!empty($inputs)) {
//    $output = implode("\n", $outputArray);
    $output = $pdoFetch->getChunk(
        $tpl,
        array("inputs" => $inputs, "product_price" => $price, "var" => $var),
        true
    );
}
if ($js = trim($modx->getOption('msal_frontend_js'))) {
    if (!empty($js) && preg_match('/\.js/i', $js)) {
        $modx->regClientScript(preg_replace(array('/^\n/', '/\t{7}/'), '', '
                    <script type="text/javascript">
                        var msal = {}; msal.price_target="'. $priceTarget. '";
                        msal.price_orig_target="'.$priceOrigTarget.'";
                    </script>
                    '), true);
        $modx->regClientScript(str_replace('[[+jsUrl]]', '/assets/components/msaddlinked/js/', $js));
    }
}

return $output;