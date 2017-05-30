<!-- BEGIN: Google Zertifizierte Haendler -->
{block name='arv_google_certified_shops_header'}
    <script type="text/javascript">
        var gts = gts || [];

        gts.push(["id", "{$ARV_GTS_TRUSTED_STORE_ID|escape:'javascript'}"]);
        gts.push(["badge_position", "{$ARV_GTS_BADGE_POSITION|escape:'javascript'}"]);
        gts.push(["locale", "{$ARV_GTS_LOCALE|escape:'javascript'}"]);

        {if $ARV_GTS_BADGE_POSITION == 'USER_DEFINED'}
            gts.push(["badge_container", "GTS_CONTAINER"]);
        {/if}
        {if !empty($sArticle) && !empty($sArticle['articleID'])}
            gts.push(["google_base_offer_id", "{$sArticle.articleID|escape:'javascript'}"]);
        {elseif !empty($sArticles)}
            {foreach from=$sArticles item=ARV_GTS_PRODUCT name=ARV_GTS_PRODUCTS}
                {if $smarty.foreach.ARV_GTS_PRODUCTS.first}
                    gts.push(["google_base_offer_id", "{$ARV_GTS_PRODUCT.articleID|escape:'javascript'}"]);
                {/if}
            {/foreach}
        {elseif !empty($sBasket.content)}
            {foreach from=$sBasket.content item=ARV_GTS_PRODUCT name=ARV_GTS_PRODUCTS}
                {if $smarty.foreach.ARV_GTS_PRODUCTS.first}
                    gts.push(["google_base_offer_id", "{$ARV_GTS_PRODUCT.articleID|escape:'javascript'}"]);
                {/if}
            {/foreach}
        {/if}
        gts.push(["google_base_subaccount_id", "{$ARV_GTS_GOOGLE_SHOPPING_ACCOUNT_ID|escape:'javascript'}"]);
        gts.push(["google_base_country", "{$ARV_GTS_GOOGLE_SHOPPING_COUNTRY|escape:'javascript'}"]);
        gts.push(["google_base_language", "{$ARV_GTS_GOOGLE_GOOGLE_SHOPPING_LANGUAGE|escape:'javascript'}"]);
        (function () {
            var gts = document.createElement("script");
            gts.type = "text/javascript";
            gts.async = true;
            gts.src = "https://www.googlecommerce.com/trustedstores/api/js";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(gts, s);
        })();
    </script>
{/block}
<!-- END: Google Zertifizierte Haendler -->