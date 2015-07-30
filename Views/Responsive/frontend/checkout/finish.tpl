{extends file="parent:frontend/checkout/finish.tpl"}

{block name='frontend_index_header_javascript_jquery' append}
    {if $sOrderNumber || $sTransactionumber}
        {include file="ArvGoogleCertifiedShops/checkout.tpl"}
    {/if}
{/block}
