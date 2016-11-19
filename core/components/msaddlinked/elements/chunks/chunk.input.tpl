<input type="hidden" id="msal_price_original" value="{$_modx->getPlaceholder('price')}">
<input type="hidden" id="msal_hash" value="{$hash}" name="msal_key">
{foreach $inputs as $input}
    <div class="col-md-6">
        <label class="col-md-7" for="msal_{$input.id}">{$input.pagetitle} {$input.price} {'ms2_frontend_currency'| lexicon}</label>
        <div class="col-md-5">
            <input type="{$input.input_type}" name="options[{$var}][{$input.id}]"
                   class="form-control msal_input"
                   id="msal_{$input.id}"
                   data-price="{$input.price}"
                   data-discount="{$input.discount}"
                   {if $input.input_type != 'checkbox'}value="{$input.value}"{/if}
                   {if $input.input_type == 'checkbox' and $input.value !== ''}checked{/if}>
        </div>
    </div>
{/foreach}
