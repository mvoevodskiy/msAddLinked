<?php

switch ($modx->event->name) {

    case 'msOnAddToCart':
        /* @var msCartHandler $cart */
        $var = $modx->getOption('msal_session_variable', null, 'msal');
        $cartArray = $cart->get();
        $options = &$cartArray[$key]['options'];
        if (isset($options[$var])) {
            $additionalPrice = 0;
            foreach ($options[$var] as $pKey => $count) {

                $linked = explode('__', $pKey);

                if (empty($count)) {
                    unset($options[$var][$pKey]);
                    continue;
                } elseif ($linked[0] == 'radio') {
                    $id = $count;
                    $count = 1;
                    $options[$var][$id . '__' . $linked[1]] = $count;
                    unset($options[$var][$pKey]);
                } else {
                    $id = $linked[0];
                }

                if ($count == 'on') {
                    $count = 1;
                } elseif ($count !== '' and ((int) $count)) {
                    $count = (int) $count;
                } elseif ($count === '') {
                    $count = 0;
                }

                if ($linkedMSP = $modx->getObject('msProduct', (int) $id)) {
                    $additionalPrice = $additionalPrice + $linkedMSP->get('price') * $count;
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