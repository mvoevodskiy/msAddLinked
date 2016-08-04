{'msal_block_name'| lexicon}
{foreach $links as $link}
    {$link.linked_name} {if $link.linked_count > 1}({$link.linked_count} {'ms2_frontend_count_unit' | lexicon}){/if}
{/foreach}