<?php

use Doctrine\Common\Collections\ArrayCollection;
use Shopware\Components\Theme\LessDefinition;
use Shopware\Models\Category\Repository;

/**
 * Class Shopware_Plugins_Frontend_ArvGoogleCertifiedShops_Bootstrap
 */
class Shopware_Plugins_Frontend_ArvGoogleCertifiedShops_Bootstrap extends Shopware_Components_Plugin_Bootstrap
{

    /**
     * @return string
     */
    public function getVersion()
    {
        return '1.0.0';
    }

    /**
     * Get (nice) name for plugin manager list
     * @return string
     */
    public function getLabel()
    {
        return 'Google Certified Shops';
    }

    /**
     * Get version tag of this plugin to display in manager
     * @return string
     */
    public function getInfo()
    {
        return array(
            'version' => $this->getVersion(),
            'autor' => 'arvatis media GmbH',
            'label' => $this->getLabel(),
            'source' => "Community",
            'description' => '',
            'license' => 'commercial',
            'copyright' => 'Copyright © 2014, arvatis media GmbH',
            'support' => '',
            'link' => 'http://www.arvatis.com/'
        );
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
        $this->subscribeEvent(
            'Enlight_Controller_Action_PostDispatch_Frontend',
            'onPostDispatch'
        );
    }

    /**
     * Create the Plugin Settings Form
     */
    public function createForm()
    {
        $form = $this->Form();
        /** @var \Shopware\Models\Config\Form $parent */

        $range = range(0,60);
        $estimates = [];
        foreach ($range as $number) {
            $estimates[] = [$number, '+' . $number . ' Day(s)'];
        }

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

        if (empty($config->TRUSTED_STORE_ID)) {
            return;
        }

        $view->addTemplateDir(__DIR__.'/Views/Common');

        $version = Shopware()->Shop()->getTemplate()->getVersion();
        if ($version >= 3) {
            $view->addTemplateDir(__DIR__.'/Views/Responsive');
        }

        $now = new Zend_Date();
        $dateShipping = $now->addDay($config->ORDER_EST_SHIP_DATE)->toString('Y-m-d');

        $now = new Zend_Date();
        $dateDelivery = $now->addDay($config->ORDER_EST_DELIVERY_DATE)->toString('Y-m-d');

        $view->ARV_GTS_TRUSTED_STORE_ID = $config->TRUSTED_STORE_ID;
        $view->ARV_GTS_BADGE_POSITION = $config->BADGE_POSITION;
        $view->ARV_GTS_LOCALE = Shopware()->Locale()->toString();
        $view->ARV_GTS_COUNTRY = Shopware()->Locale()->getRegion();
        $view->ARV_GTS_MERCHANT_ORDER_DOMAIN = $config->MERCHANT_ORDER_DOMAIN;
        $view->ARV_GTS_ORDER_EST_SHIP_DATE = $dateShipping;
        $view->ARV_GTS_ORDER_EST_DELIVERY_DATE = $dateDelivery;
    }

    /**
     * @return bool
     */
    public function uninstall()
    {
        return true;
    }
}