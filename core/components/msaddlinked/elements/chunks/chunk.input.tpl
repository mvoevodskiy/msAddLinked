<input type="hidden" id="msal_price_original" value="{$_modx->getPlaceholder('price')}">
<input type="hidden" id="msal_hash" value="{$hash}" name="msal_key">
<input type="hidden" id="msal_show_cost" value="{$show_cost}" name="msal_show_cost">
{foreach $inputs as $input}
    <div class="col-md-6">
        <label class="col-md-7" for="msal_{$input.id}">{$input.pagetitle} <span id="msal_cost_{$input.id}">{$input.price}</span>  {'ms2_frontend_currency'| lexicon}</label>
        <div class="col-md-5">
            <input type="{$input_type}" name="{$input.input_name}"
                   class="form-control msal_input"
                   id="msal_{$input.id}"
                   data-price="{$input.price}"
                   minlength="0"
                   data-discount="{$input.discount != '' ? $input.discount : ' '}"
                   {if $input_type != 'checkbox'}value="{$input.value}"{/if}
                   {if $input_type == 'checkbox' and $input.value !== ''}checked{/if}>
        </div>
    </div>
{/foreach}
