{extends file='parent:frontend/index/index.tpl'}

{block name='frontend_index_header_javascript' append}
    {if $ARV_GTS_TRUSTED_STORE_ID}
        {include file="ArvGoogleCertifiedShops/header.tpl"}
    {/if}
{/block}

{block name='frontend_index_body_inline' append}
    {if $ARV_GTS_BADGE_POSITION == 'USER_DEFINED'}
        <div id="GTS_CONTAINER"></div>
    {/if}

    arvgoogle {$ARV_GTS_TRUSTED_STORE_ID} {$ARV_GTS_BADGE_POSITION}
{/block}