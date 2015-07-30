<!-- BEGIN: Google Zertifizierte Haendler -->
<script type="text/javascript">
    var gts = gts || [];

    gts.push(["id", "{$ARV_GTS_TRUSTED_STORE_ID|escape:'javascript'}"]);
    gts.push(["badge_position", "{$ARV_GTS_BADGE_POSITION|escape:'javascript'}"]);
    gts.push(["locale", "{$ARV_GTS_LOCALE|escape:'javascript'}"]);

    {if $ARV_GTS_BADGE_POSITION == 'USER_DEFINED'}
        gts.push(["badge_container", "GTS_CONTAINER"]);
    {/if}

    {*
        gts.push(["google_base_offer_id", "ITEM_GOOGLE_SHOPPING_ID"]);
        gts.push(["google_base_subaccount_id", "2904219"]);
        gts.push(["google_base_country", "DE"]);
        gts.push(["google_base_language", "de"]);
    *}

    (function() {
        var gts = document.createElement("script");
        gts.type = "text/javascript";
        gts.async = true;
        gts.src = "https://www.googlecommerce.com/trustedstores/api/js";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(gts, s);
    })();
</script>
<!-- END: Google Zertifizierte Haendler -->