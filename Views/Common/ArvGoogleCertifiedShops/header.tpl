<!-- BEGIN: Google Zertifizierte Haendler -->
<script type="text/javascript">
    var gts = gts || [];

    gts.push(["id", "{$ARV_GTS_TRUSTED_STORE_ID|escape:'javascript'}"]);
    gts.push(["badge_position", "{$ARV_GTS_BADGE_POSITION|escape:'javascript'}"]);
    gts.push(["locale", "{$ARV_GTS_LOCALE|escape:'javascript'}"]);

    {if $ARV_GTS_BADGE_POSITION == 'USER_DEFINED'}
        gts.push(["badge_container", "GTS_CONTAINER"]);
    {/if}

    {if !empty($sArticle) && !empty($sArticle['articleID'])}
        gts.push(["google_base_offer_id", "{$sArticle['articleID']|escape:'javascript'}"]);
    {elseif !empty($sArticles) && !empty($sArticles[0]['articleID'])}
        gts.push(["google_base_offer_id", "{$sArticles[0]['articleID']|escape:'javascript'}"]);
    {elseif !empty($sBasket.content) && !empty($sBasket.content[0]['articleID'])}
        gts.push(["google_base_offer_id", "{$sBasket.content[0]['articleID']|escape:'javascript'}"]);
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
<!-- END: Google Zertifizierte Haendler -->

{debug}