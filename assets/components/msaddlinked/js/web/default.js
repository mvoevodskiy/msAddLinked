/**
 * Created by mvoevodskiy on 20.07.16.
 */
$(document).on('ready', function() {
    msal.orig_price = 0;
    msal.additional_price = 0;
    if (msal.price_target === undefined) {
        msal.price_target = '#price';
    }
    if (msal.price_orig_target === undefined) {
        msal.price_orig_target = '#msal_price_original';
    }

    $(document).on('change', '.msal_input', function (event) {
        msal.orig_price = parseInt($(msal.price_orig_target).val());
        msal.additional_price = 0;

        $('.msal_input').each(function() {
            add_price = parseInt($(this).data('price'));
            if ($(this).attr('type') === 'checkbox') {
                if ($(this).is(':checked')) {
                   msal.additional_price = msal.additional_price + add_price;
                }
            } else {
                if ($(this).attr('type') === 'radio') {
                    if ($(this).is(':checked')) {
                        count = 1;
                    } else {
                        count = 0;
                    }
                } else {
                    count = parseInt($(this).val());
                }
                if (!isNaN(count)) {
                    msal.additional_price = msal.additional_price + add_price * count;
                }
            }
        });

        new_price = miniShop2.Utils.formatPrice(msal.orig_price + msal.additional_price);
        $(msal.price_target).html(new_price);

    });
});