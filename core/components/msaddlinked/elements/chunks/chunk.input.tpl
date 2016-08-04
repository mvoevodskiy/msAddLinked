<input type="hidden" id="msal_price_original" value="{$_pls['product_price']}">
{foreach $_pls['inputs'] as $input}
    <div class="col-md-6">
        <label class="col-md-7" for="msal_{$input.link_id}_{$input.linked_id}">{$input.linked_name} {$input.linked_price} {'ms2_frontend_currency'| lexicon}</label>
        <div class="col-md-5">
            <input type="{$input.input_type}" name="options[{$var}][{$input.linked_id}__{$input.link_id}]"
                   class="form-control msal_input"
                   id="msal_{$input.link_id}_{$input.linked_id}"
                   data-price="{$input.linked_price}"
                   {if $input.input_type != 'checkbox'}value="{$input.value}"{/if}
                    {if $input.input_type == 'checkbox' and $value !== ''}checked{/if}>
        </div>
    </div>
{/foreach}
