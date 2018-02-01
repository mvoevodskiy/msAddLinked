/**
 * Created by mvoevodskiy on 20.07.16.
 */
console.log("RUN");
$(window).on('load', function () {

    msal.orig_price = 0;
    msal.additional_price = 0;
    if (msal.price_target === undefined) {
        msal.price_target = '#price';
    }
    if (msal.price_orig_target === undefined) {
        msal.price_orig_target = '#msal_price_original';
    }
    if (msal.show_cost === undefined) {
        msal.show_cost = 0;
    }
    msal.calculatePrice = function (event) {
        msalInput = '.msal_input';

        if ($(msal.price_orig_target).val() === undefined) {
            return;
        }
        msal.orig_price = parseFloat($(msal.price_orig_target).val().replace(' ', ''));
        msal.additional_price = 0;
        msal.discount = 0;

        $(msalInput).each(function () {

            add_price = parseFloat($(this).data('price').toString().replace(' ', ''));
            add_discount = parseFloat($(this).data('discount').toString().replace(' ', ''));
            msalCostResult = $('#msal_cost_' + $(this).data('inputId'));

            if (isNaN(add_discount)) {
                add_discount = 0;
            }
            if ($(this).attr('type') === 'checkbox') {
                if ($(this).is(':checked')) {
                    msal.additional_price = msal.additional_price + add_price;
                    msal.discount = add_discount;
                }
            } else {
                if ($(this).attr('type') === 'radio') {
                    if ($(this).is(':checked')) {
                        count = 1;
                    } else {
                        count = 0;
                    }
                } else {
                    count = parseFloat($(this).val());
                }
                if (!isNaN(count)) {

                    msal.additional_price = msal.additional_price + add_price * count;
                    msal.discount = add_discount * count;
                    if (count > 0) {
                        $(msalCostResult).text('+' + miniShop2.Utils.formatPrice(add_price * count));
                    } else {
                        $(msalCostResult).text(miniShop2.Utils.formatPrice(add_price));
                    }
                }
            }

        });

        new_price = miniShop2.Utils.formatPrice(msal.orig_price + msal.additional_price - msal.discount);
        full_price = miniShop2.Utils.formatPrice(msal.orig_price + msal.additional_price);
        $(msal.price_target).html(new_price);
        $(msal.price_full_target).html(full_price);

    };

    $(".msal_input").on('change', {name: ".msal_input"}, msal.calculatePrice);
    msal.calculatePrice('change');
});