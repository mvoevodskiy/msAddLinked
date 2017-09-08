<?php
/** @var array $scriptProperties */
/** @var msAddLinked $msAddLinked */
if (!$msAddLinked = $modx->getService('msaddlinked', 'msAddLinked', $modx->getOption('msaddlinked_core_path', null, $modx->getOption('core_path') . 'components/msaddlinked/') . 'model/msaddlinked/', $scriptProperties)) {
	return 'Could not load msAddLinked class!';
}
/** @var miniShop2 $ms2 */
$ms2 = $modx->getService('minishop2');
/** @var pdoFetch $pdoFetch */
$pdoFetch = $modx->getService('pdoFetch');

$tpl = $modx->getOption('tpl', $scriptProperties, 'tpl.msAddLinked.input');
//$tplOuter = $modx->getOption('tplOuter', $scriptProperties, 'tpl.msAddLinked.inputOuter');
$product_id = $modx->getOption('product', $scriptProperties, 0);
$link_id = $modx->getOption('link', $scriptProperties, 0);
$resources = $modx->getOption('resources', $scriptProperties, '');
$parents = $modx->getOption('parents', $scriptProperties, 0);
$includeTVs = $modx->getOption('includeTVs', $scriptProperties, '');
$tvPrefix = $modx->getOption('tvPrefix', $scriptProperties, 'tv.');
$class = $modx->getOption('class', $scriptProperties, 'msProduct');
$includeContent = $modx->getOption('includeContent', $scriptProperties, 0);
$input_type = $modx->getOption('inputType', $scriptProperties, 'checkbox');
$field_name = $modx->getOption('fieldName', $scriptProperties, 'pagetitle');
$field_discount = $modx->getOption('fieldDiscount', $scriptProperties, '');
$priceTarget = $modx->getOption('priceTarget', $scriptProperties, '#price');
$priceOrigTarget = $modx->getOption('priceOrigTarget', $scriptProperties, '#msal_price_original');
$priceFullTarget = $modx->getOption('priceFullTarget', $scriptProperties, '#msal_price_full');
$showCost = $modx->getOption('showCost', $scriptProperties, 0);
$toPlaceholder = $modx->getOption('toPlaceholder', $scriptProperties, false);

$var = $modx->getOption('msal_variable', null, 'msal');
$price = 0;
$output = '';
$inputs = array();
$options = array();
$ids = array();
$linksIds = array();
$hash = md5(http_build_query($scriptProperties));
$_SESSION['msal'][$hash] = $scriptProperties;

$product_id = $product_id == 0 ? $modx->resource->id : $product_id;

if ($product = $modx->getObject('msProduct', (int) $product_id)) {
    $price = $product->get('price');
} else return;

$criteria = array('master' => $product_id);
if (!is_numeric($link_id)) {
    if ($link = $modx->getObject('msLink', array('name' => $link_id ))) {
        $link_id = $link->get('id');
    } else {
        $link_id = 0;
    }
};
if ($link_id) {
    $criteria['link'] = $link_id;
}

/** @var msProductLink[] $links */
$links = $modx->getCollection('msProductLink', $criteria);
foreach ($links as $l) {
    $ids[] = $l->get('slave');
    $linksIds[$l->get('slave')] = $l->get('id');
}
$resources = implode(',', array_merge(explode(',', $resources), $ids));

$select = array(
    $class => !empty($includeContent) ?  $modx->getSelectColumns($class, $class) : $modx->getSelectColumns($class, $class, '', array('content'), true),
	'Data' => $modx->getSelectColumns('msProductData', 'Data', '', array('id'), true),
);


$config = array(
    'class' => 'msProduct',
    'loadModels' => 'miniShop2',
    'parents' => $parents,
    'resources' => $resources,
    'select' => $modx->toJSON($select),
    'where' => array(
        'msProduct.class_key' => 'msProduct',
    ),
    'leftJoin' => array(
        array('class' => 'msProductData', 'alias' => 'Data', 'on' => '`msProduct`.`id`=`Data`.`id`'),
    ),
    'return' => 'data',
);

if (!empty($field_discount) and !$modx->getCount('modTemplateVar', array('name' => $field_discount ))) {
    $config['includeTVs'] = implode(',', array_merge(explode(',', $includeTVs), array($field_discount)));
    $field_discount = $tvPrefix . $field_discount;
}

if ($resources or $parents) {
    $config = array_merge($scriptProperties, $config);
    $pdoFetch->setConfig($config);
    if ($options = $pdoFetch->run()) {
        foreach($options as &$resource) {
            $id = $resource['id'];
            $value = '';
            if ($input_type == 'radio') {
                $value = $id;
                if (isset($linksIds[$id])) {
                    $id = 'radio__' . $linksIds[$id];
                } else {
                    $id = 'radio';
                }
            }
            $discount = 0;
            if (!empty($field_discount)) {
                $discount = $resource[$field_discount];
            }
            $resource['price'] = $ms2->formatPrice($resource['price']);
            $inputs[] = array_merge(
                $resource,
                array(
                    'discount' => $discount,
                    "input_type" => $input_type,
                    "value" => $value,
                    ),
                // Более не используется. Оставлено для обратной совместимости
                array(
                    "linked_id" => $id,
                    "linked_name" => $resource[$field_name],
                    "linked_price" => $ms2->formatPrice($resource['price']),
                    "link_id" => 0,
                    "field_name" => $field_name,
                    "linked_discount" => $discount,
                    )
                );
        }

    }
}

if (!empty($inputs)) {
//    $output = implode("\n", $outputArray);
    $output = $pdoFetch->getChunk(
        $tpl,
        array(
            "options" => $options,
            "inputs" => $inputs,
            "product_price" => $price,
            "var" => $var,
            "hash" => $hash,
            "input_type" => $input_type,
            "field_discount" => $field_discount,
        ),
        true
    );
}
if ($js = trim($modx->getOption('msal_frontend_js'))) {
    if (!empty($js) && preg_match('/\.js/i', $js)) {
        $modx->regClientScript(preg_replace(array('/^\n/', '/\t{7}/'), '', '
                    <script type="text/javascript">
                        var msal = {}; msal.price_target="'. $priceTarget. '";
                        msal.price_orig_target="'.$priceOrigTarget.'";
                        msal.price_full_target="'.$priceFullTarget.'";
                        msal.show_cost=' . ($showCost ?: 0) . ';
                    </script>
                    '), true);
        $modx->regClientScript(str_replace('[[+jsUrl]]', MODX_ASSETS_URL . 'components/msaddlinked/js/', $js));
    }
}

return $output; #.'<pre class="pdoResourcesLog">' . print_r($pdoFetch->getTime(), 1) . '</pre>';