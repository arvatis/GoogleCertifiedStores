{block name='frontend_index_body_inline' append}
    {if $sOrderNumber || $sTransactionumber}
        {include file="ArvGoogleCertifiedShops/checkout.tpl"}
    {/if}
{/block}
