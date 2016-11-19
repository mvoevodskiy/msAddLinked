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
            $field_discount = $modx->getOption('fieldDiscount', $scriptProperties, '');
            foreach ($options[$var] as $pKey => $value) {

                $id = $pKey;
                if (strpos($pKey, '__') !== false) {
                    list($id, ) = explode('__', $pKey);
                }

                if (empty($value)) {
                    unset($options[$var][$pKey]);
                    continue;
                } elseif ($value == 'radio') {
                    $id = (int) $value;
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
                    $additionalPrice = $additionalPrice + ($linkedMSP->get('price') - $discount) * $count;
                }

            }
            $cartArray[$key]['price'] = $cartArray[$key]['price'] + $additionalPrice;
            $options[$var] = json_encode($options[$var]);
            $cart->set($cartArray);
        }
        break;

    default:
        break;

}