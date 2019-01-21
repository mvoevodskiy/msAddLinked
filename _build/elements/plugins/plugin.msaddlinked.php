<?php
/* @var array $scriptProperties */

switch ($modx->event->name) {

    case 'msOnAddToCart':
        /* @var msCartHandler $cart */
        $var = $modx->getOption('msal_session_variable', null, 'msal');
        $cartArray = $cart->get();
        $options = &$cartArray[$key]['options'];
        if (isset($options[$var])) {
            $additionalPrice = 0;
            if (isset($_POST['msal_key']) and isset($_SESSION['msal'][$_POST['msal_key']])) {
                $scriptProperties = array_merge($scriptProperties, $_SESSION['msal'][$_POST['msal_key']]);
            }
            $fieldPrice = $modx->getOption('fieldPrice', $scriptProperties, 'price');
            $field_discount = $modx->getOption('fieldDiscount', $scriptProperties, '');
            foreach ($options[$var] as $pKey => $value) {

                $id = $pKey;
                if (strpos($pKey, '__') !== false) {
                    list($id, ) = explode('__', $pKey);
                }

                if (empty($value)) {
                    unset($options[$var][$pKey]);
                    continue;
                } elseif ($id == 'radio') {
                    $id = (int) $value;
                    $value = 1;
                    $count = 1;
                    $options[$var][$id] = $count;
                    unset($options[$var][$pKey]);
                }

                if ($value == 'on') {
                    $count = 1;
                } elseif ($value !== '' and ((int) $value)) {
                    $count = (int) $value;
                } elseif ($count === '') {
                    $count = 0;
                }

                if ($linkedMSP = $modx->getObject('msProduct', (int) $id)) {
                    $discount = 0;
                    if ($field_discount) {
                        if (in_array($field_discount, $linkedMSP->fieldNames) or in_array($field_discount, $linkedMSP->getDataFieldsNames())) {
                            $discount = $linkedMSP->get($field_discount);
                        } else {
                            $discount = $linkedMSP->getTVValue($field_discount);
                        }
                    }
                    $additionalPrice = $additionalPrice + ($linkedMSP->get($fieldPrice) - $discount) * $count;
                }

            }
            $cartArray[$key]['price'] = $cartArray[$key]['price'] + $additionalPrice;
            $options[$var] = json_encode($options[$var]);
            $cart->set($cartArray);
        }
        break;

    case 'msOnBeforeCreateOrder':
        $var = $modx->getOption('msal_session_variable', null, 'msal');
        $orderOptions = '';
        /** @var msOrder $msOrder */
        /** @var msOrderProduct[] $products */
        $products = $msOrder->getMany('Products');
        foreach ($products as $product) {
            $options = $product->get('options');
            if (isset($options[$var])) {
                $productOptions = $product->get('name') . ' ' .
                    $product->get('count') . ' ' . $modx->lexicon('ms2_frontend_count_unit') . ' ' .
                    $product->get('cost') . ' ' . $modx->lexicon('ms2_frontend_currency') . ' ' .
                    $modx->runSnippet('msAddLinked.info', array('option' => $options[$var]));
                $options[$var.'text'] = $productOptions;
                $product->set('options', $options);
                $orderOptions .= $productOptions . PHP_EOL;
            }
        }
        if ($orderOptions) {
            $comment = $msOrder->get('comment');
            if ($comment) {
                $comment .= PHP_EOL.PHP_EOL;
            }
            $comment .= $orderOptions;
            $msOrder->set('comment', $comment);
        }
        break;


    default:
        break;

}