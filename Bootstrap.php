<?php

/**
 * Class Shopware_Plugins_Frontend_ArvGoogleCertifiedShops_Bootstrap
 */
class Shopware_Plugins_Frontend_ArvGoogleCertifiedShops_Bootstrap extends Shopware_Components_Plugin_Bootstrap
{
    /**
     * Get version tag of this plugin to display in manager
     * @return string
     */
    public function getInfo()
    {
        return [
            'version' => $this->getVersion(),
            'autor' => 'arvatis media GmbH',
            'label' => $this->getLabel(),
            'source' => 'Community',
            'description' => '',
            'license' => 'commercial',
            'copyright' => 'Copyright © 2015, arvatis media GmbH',
            'support' => '',
            'link' => 'http://www.arvatis.com/'
        ];
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return '1.0.9';
    }

    /**
     * Get (nice) name for plugin manager list
     *
     * @return string
     */
    public function getLabel()
    {
        return 'Google Certified Shops';
    }

    /**
     * Install plugin method
     *
     * @return bool
     */
    public function install()
    {
        $this->subscribeEvents();
        $this->createForm();

        return true;
    }

    /**
     * Register Events
     */
    private function subscribeEvents()
    {
        $this->subscribeEvent('Enlight_Controller_Action_PostDispatch_Frontend', 'onPostDispatch');
    }

    /**
     * Create the Plugin Settings Form
     */
    public function createForm()
    {
        $form = $this->Form();

        $range = range(0, 60);
        $estimates = array();
        foreach ($range as $number) {
            $estimates[] = array($number, '+' . $number . ' Day(s)');
        }

        /**
         * @var \Shopware\Models\Config\Form $parent
         */
        $parent = $this->Forms()->findOneBy(array('name' => 'Interface'));
        $form->setParent($parent);

        $form->setElement('text', 'TRUSTED_STORE_ID', array(
            'label' => 'Google Trusted Stores ID',
            'value' => null,
            'scope' => \Shopware\Models\Config\Element::SCOPE_SHOP
        ));

        $form->setElement('combo', 'BADGE_POSITION', array(
            'label' => 'Badge position',
            'value' => 'BOTTOM_RIGHT',
            'store' => array(
                array('BOTTOM_RIGHT', 'BOTTOM_RIGHT'),
                array('BOTTOM_LEFT', 'BOTTOM_LEFT'),
                array('USER_DEFINED', 'USER_DEFINED'),
            ),
            'description' => 'The default value for this variable is BOTTOM_RIGHT. Change this value to BOTTOM_LEFT if you would like the badge to float in the bottom left corner instead. You may also set this value to USER_DEFINED to specify a non-floating location for the badge on a given web page.',
            'scope' => \Shopware\Models\Config\Element::SCOPE_SHOP
        ));

        $form->setElement('combo', 'ORDER_EST_SHIP_DATE', array(
            'label' => 'Estimated shipping date',
            'value' => '0',
            'store' => $estimates,
            'scope' => \Shopware\Models\Config\Element::SCOPE_SHOP
        ));

        $form->setElement('combo', 'ORDER_EST_DELIVERY_DATE', array(
            'label' => 'Estimated delivery date',
            'value' => '0',
            'store' => $estimates,
            'scope' => \Shopware\Models\Config\Element::SCOPE_SHOP
        ));

        $form->setElement('text', 'MERCHANT_ORDER_DOMAIN', array(
            'label' => 'Merchant Domain',
            'value' => null,
            'description' => 'Domain name associated with the order, formatted as www.mystore.com. If checkout takes place on a domain different from where your product pages are hosted, you should use the domain that hosts the product pages. The intent is for Google to know the domain where the customer added the item(s) to their cart.',
            'scope' => \Shopware\Models\Config\Element::SCOPE_SHOP
        ));

        $form->setElement('text', 'GOOGLE_SHOPPING_ACCOUNT_ID', array(
            'label' => 'Google Shopping Account ID',
            'value' => null,
            'description' => 'Account ID from Google Merchant Center. This value should match the account ID you use to submit your product data feed to Google Shopping through Google Merchant center. If you have a MCA account, use the subaccount ID associated with that product feed.',
            'scope' => \Shopware\Models\Config\Element::SCOPE_SHOP
        ));

        $form->setElement('text', 'GOOGLE_SHOPPING_COUNTRY', array(
            'label' => 'Google Shopping country',
            'value' => null,
            'description' => 'Account country from Google Shopping. This value should match the account country you use to submit your product data feed to Google Shopping. The value of the country parameter should be a two-letter ISO 3166 country code. For example, values could be “US”, “GB”, “AU”, “FR”, “DE”, “JP”.',
            'scope' => \Shopware\Models\Config\Element::SCOPE_SHOP
        ));

        $form->setElement('text', 'GOOGLE_SHOPPING_LANGUAGE', array(
            'label' => 'Google Shopping language',
            'value' => null,
            'description' => 'Account language from Google Shopping. This value should match the account language you use to submit your product data feed to Google Shopping. The value of the language parameter should be a two-letter ISO 639-1 language code. For example, values could be "en", "fr", "de", "ja".',
            'scope' => \Shopware\Models\Config\Element::SCOPE_SHOP
        ));

        $this->addFormTranslations(
            array(
                'de_DE' => array(
                    'TRUSTED_STORE_ID' => array(
                        'label' => 'Google Zertifizierte Händler-ID'
                    ),
                    'BADGE_POSITION' => array(
                        'label' => 'Gütesiegel Position',
                        'description' => 'Der Standardwert dieser Variablen lautet BOTTOM_RIGHT. Alternativ können Sie diesen Wert auf USER_DEFINED setzen, um dem Gütesiegel eine andere, feste Position in Relation zu den anderen Inhalten auf einer bestimmten Webseite zuzuweisen.',
                    ),
                    'ORDER_EST_SHIP_DATE' => array(
                        'label' => 'Voraussichtliches Versanddatum'
                    ),
                    'ORDER_EST_DELIVERY_DATE' => array(
                        'label' => 'Voraussichtlicher Liefertermin'
                    ),
                    'MERCHANT_ORDER_DOMAIN' => array(
                        'label' => 'Händler Domain',
                        'description' => 'Dies ist der Domainname zu der Bestellung im Format www.ihremusterdomain.de. Wenn Produktseiten und Seiten zum Abschluss des Kaufvorgangs auf verschiedenen Domains gehostet sind, sollten Sie die Domain verwenden, auf der sich die Produktseiten befinden. Dadurch soll Google die Domain mitgeteilt werden, auf der der Kunde Artikel zu seinem Warenkorb hinzugefügt hat.',
                    ),
                    'GOOGLE_SHOPPING_ACCOUNT_ID' => array(
                        'label' => 'Google Shopping-Kundennummer',
                        'description' => 'Kundennummer im Google Merchant Center. Dieser Wert muss mit der Kundennummer übereinstimmen, die Sie zum Senden Ihres Produktdatenfeeds an Google Shopping über das Google Merchant Center verwenden. Wenn Sie ein MCA-Konto haben, verwenden Sie die Kundennummer des Unterkontos, das mit diesem Produktfeed verknüpft ist.',
                    ),
                    'GOOGLE_SHOPPING_COUNTRY' => array(
                        'label' => 'Google Shopping-Land',
                        'description' => 'Geben Sie dieses Feld nur an, wenn Sie Feeds an Google Shopping senden. Dies ist das Land des Kontos aus Google Shopping. Dieser Wert sollte mit dem Land des Kontos übereinstimmen, das Sie verwenden, um Ihren Produktdatenfeed an Google Shopping zu senden. Der Wert des Parameters für das Land sollte ein aus zwei Buchstaben bestehender ISO 3166-Ländercode sein.',
                    ),
                    'GOOGLE_SHOPPING_LANGUAGE' => array(
                        'label' => 'Google Shopping-Sprache',
                        'description' => 'Geben Sie dieses Feld nur an, wenn Sie Feeds an Google Shopping senden. Dies ist die Sprache des Kontos aus Google Shopping. Dieser Wert sollte mit der Sprache des Kontos übereinstimmen, das Sie verwenden, um Ihren Produktdatenfeed an Google Shopping zu senden. Der Wert des Parameters für die Sprache sollte ein aus zwei Buchstaben bestehender ISO 639-1-Sprachcode sein.',
                    )
                )
            )
        );

    }

    /**
     * @param string $version
     * @return array
     */
    public function update($version)
    {
        // Remove update zip if it exists
        $updateFile = __DIR__ . '/ArvGoogleCertifiedShops.zip';
        if (file_exists($updateFile)) {
            unlink($updateFile);
        }

        if (version_compare($version, '1.0.7', '<')) {
            try {
                $this->createForm();
            } catch (Exception $e) {
                return [
                    'success' => false,
                    'message' => $e->getMessage()
                ];
            }
        }

        return [
            'success' => true,
        ];
    }

    /**
     * Event listener method
     *
     * @param Enlight_Controller_ActionEventArgs $args
     */
    public function onPostDispatch(Enlight_Controller_ActionEventArgs $args)
    {
        $request = $args->getSubject()->Request();
        $view = $args->getSubject()->View();

        if ($request->isXmlHttpRequest()) {
            return;
        }

        $config = $this->Config();

        $value = $config->get('TRUSTED_STORE_ID');
        if (empty($value)) {
            return;
        }

        $view->addTemplateDir(__DIR__ . '/Views/Common');

        $version = Shopware()->Shop()->getTemplate()->getVersion();
        if ($version >= 3) {
            $view->addTemplateDir(__DIR__ . '/Views/Responsive');
        } else {
            $view->addTemplateDir(__DIR__ . '/Views/Emotion');
            $view->extendsTemplate('frontend/index/index_google.tpl');

            if ($request->getActionName() === 'finish') {
                $view->extendsTemplate('frontend/checkout/finish_google.tpl');
            }
        }

        try {
            $now = new Zend_Date();
            $dateShipping = $now->addDay($config->get('ORDER_EST_SHIP_DATE'))->toString('YYYY-MM-dd');

            $now = new Zend_Date();
            $dateDelivery = $now->addDay($config->get('ORDER_EST_DELIVERY_DATE'))->toString('YYYY-MM-dd');
        } catch (Exception $e) {
            $dateShipping = $dateDelivery = new Zend_Date();
        }

        $view->assign('ARV_GTS_TRUSTED_STORE_ID', $config->get('TRUSTED_STORE_ID'));
        $view->assign('ARV_GTS_BADGE_POSITION', $config->get('BADGE_POSITION'));
        $view->assign('ARV_GTS_LOCALE', Shopware()->Locale()->toString());
        $view->assign('ARV_GTS_COUNTRY', Shopware()->Locale()->getRegion());
        $view->assign('ARV_GTS_MERCHANT_ORDER_DOMAIN', $config->get('MERCHANT_ORDER_DOMAIN'));
        $view->assign('ARV_GTS_ORDER_EST_SHIP_DATE', $dateShipping);
        $view->assign('ARV_GTS_ORDER_EST_DELIVERY_DATE', $dateDelivery);
        $view->assign('ARV_GTS_BASKET_CURRENCY', Shopware()->Currency()->getShortName());
        $view->assign('ARV_GTS_GOOGLE_SHOPPING_ACCOUNT_ID', $config->get('GOOGLE_SHOPPING_ACCOUNT_ID'));
        $view->assign('ARV_GTS_GOOGLE_SHOPPING_COUNTRY', $config->get('GOOGLE_SHOPPING_COUNTRY'));
        $view->assign('ARV_GTS_GOOGLE_GOOGLE_SHOPPING_LANGUAGE', $config->get('GOOGLE_SHOPPING_LANGUAGE'));
    }

    /**
     * @return bool
     */
    public function uninstall()
    {
        return true;
    }
}
