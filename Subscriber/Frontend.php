<?php

namespace ArvGoogleCertifiedShops\Subscriber;

use Enlight\Event\SubscriberInterface;
use \Exception;
use Shopware\Components\Plugin\CachedConfigReader;
use Shopware\Components\Plugin\ConfigReader;
use \Zend_Date;

class Frontend implements SubscriberInterface
{
    /**
     * Frontend constructor.
     *
     * @param CachedConfigReader|ConfigReader      $configReader
     */
    public function __construct(ConfigReader $configReader)
    {
        $this->config = $configReader->getByPluginName('ArvGoogleRemarketing', Shopware()->Shop());
    }

    public static function getSubscribedEvents()
    {
        return array(
            'Enlight_Controller_Action_PostDispatch_Frontend' => 'onPostDispatch'
        );
    }

    /**
     * Event listener method
     *
     * @param \Enlight_Controller_ActionEventArgs $args
     * @throws \Zend_Date_Exception
     * @throws \Exception
     */
    public function onPostDispatch(\Enlight_Controller_ActionEventArgs $args)
    {
        $request = $args->getSubject()->Request();
        $view = $args->getSubject()->View();

        if ($request->isXmlHttpRequest()) {
            return;
        }

        $config = Shopware()->Container()->get('shopware.plugin.config_reader')->getByPluginName('ArvGoogleCertifiedShops');

        $value = $config['TRUSTED_STORE_ID'];
        if (empty($value)) {
            return;
        }

        $view->addTemplateDir(__DIR__ . '/../Views/Common');

        $version = Shopware()->Shop()->getTemplate()->getVersion();
        if ($version >= 3) {
            $view->addTemplateDir(__DIR__ . '/../Views/Responsive');
        } else {
            $view->addTemplateDir(__DIR__ . '/../Views/Emotion');
            $view->extendsTemplate('frontend/index/index_google.tpl');

            if ($request->getActionName() === 'finish') {
                $view->extendsTemplate('frontend/checkout/finish_google.tpl');
            }
        }

        try {
            $now = new Zend_Date();
            $dateShipping = $now->addDay($config['ORDER_EST_SHIP_DATE'])->toString('YYYY-MM-dd');

            $now = new Zend_Date();
            $dateDelivery = $now->addDay($config['ORDER_EST_DELIVERY_DATE'])->toString('YYYY-MM-dd');
        } catch (Exception $e) {
            $dateShipping = $dateDelivery = new Zend_Date();
        }
        $view->assign('ARV_GTS_TRUSTED_STORE_ID', $config['TRUSTED_STORE_ID']);
        $view->assign('ARV_GTS_BADGE_POSITION', $config['BADGE_POSITION']);
        $view->assign('ARV_GTS_LOCALE', Shopware()->Locale()->toString());
        $view->assign('ARV_GTS_COUNTRY', Shopware()->Locale()->getRegion());
        $view->assign('ARV_GTS_MERCHANT_ORDER_DOMAIN', $config['MERCHANT_ORDER_DOMAIN']);
        $view->assign('ARV_GTS_ORDER_EST_SHIP_DATE', $dateShipping);
        $view->assign('ARV_GTS_ORDER_EST_DELIVERY_DATE', $dateDelivery);
        $view->assign('ARV_GTS_BASKET_CURRENCY', Shopware()->Currency()->getShortName());
        $view->assign('ARV_GTS_GOOGLE_SHOPPING_ACCOUNT_ID', $config['GOOGLE_SHOPPING_ACCOUNT_ID']);
        $view->assign('ARV_GTS_GOOGLE_SHOPPING_COUNTRY', $config['GOOGLE_SHOPPING_COUNTRY']);
        $view->assign('ARV_GTS_GOOGLE_GOOGLE_SHOPPING_LANGUAGE', $config['GOOGLE_SHOPPING_LANGUAGE']);
    }
}
