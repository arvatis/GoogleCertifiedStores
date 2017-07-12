<?php

namespace ArvGoogleCertifiedShops\Subscriber;

use Enlight\Event\SubscriberInterface;
use \Exception;
use Shopware\Components\Plugin\CachedConfigReader;
use Shopware\Components\Plugin\ConfigReader;
use Symfony\Component\DependencyInjection\ContainerInterface;
use \Zend_Date;

class Frontend implements SubscriberInterface
{
    /**
     * @var array|mixed
     */
    private $config;

    /**
     * @var CachedConfigReader|ConfigReader
     */
    private $configReader;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Frontend constructor.
     *
     * @param CachedConfigReader|ConfigReader $configReader
     * @param ContainerInterface              $container
     */
    public function __construct(ConfigReader $configReader, ContainerInterface $container)
    {
        $this->configReader = $configReader;
        $this->container = $container;
    }

    public static function getSubscribedEvents()
    {
        return array(
            'Enlight_Controller_Action_PostDispatch_Frontend' => 'onPostDispatch'
        );
    }

    private function getConfig()
    {
        $this->config = $this->configReader->getByPluginName('ArvGoogleRemarketing', $this->container->get('shop'));
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
        $this->getConfig();
        $request = $args->getSubject()->Request();
        $view = $args->getSubject()->View();

        if ($request->isXmlHttpRequest()) {
            return;
        }

        $value = $this->config['TRUSTED_STORE_ID'];
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
            $dateShipping = $now->addDay($this->config['ORDER_EST_SHIP_DATE'])->toString('YYYY-MM-dd');

            $now = new Zend_Date();
            $dateDelivery = $now->addDay($this->config['ORDER_EST_DELIVERY_DATE'])->toString('YYYY-MM-dd');
        } catch (Exception $e) {
            $dateShipping = $dateDelivery = new Zend_Date();
        }
        $view->assign('ARV_GTS_TRUSTED_STORE_ID', $this->config['TRUSTED_STORE_ID']);
        $view->assign('ARV_GTS_BADGE_POSITION', $this->config['BADGE_POSITION']);
        $view->assign('ARV_GTS_LOCALE', Shopware()->Locale()->toString());
        $view->assign('ARV_GTS_COUNTRY', Shopware()->Locale()->getRegion());
        $view->assign('ARV_GTS_MERCHANT_ORDER_DOMAIN', $this->config['MERCHANT_ORDER_DOMAIN']);
        $view->assign('ARV_GTS_ORDER_EST_SHIP_DATE', $dateShipping);
        $view->assign('ARV_GTS_ORDER_EST_DELIVERY_DATE', $dateDelivery);
        $view->assign('ARV_GTS_BASKET_CURRENCY', Shopware()->Currency()->getShortName());
        $view->assign('ARV_GTS_GOOGLE_SHOPPING_ACCOUNT_ID', $this->config['GOOGLE_SHOPPING_ACCOUNT_ID']);
        $view->assign('ARV_GTS_GOOGLE_SHOPPING_COUNTRY', $this->config['GOOGLE_SHOPPING_COUNTRY']);
        $view->assign('ARV_GTS_GOOGLE_GOOGLE_SHOPPING_LANGUAGE', $this->config['GOOGLE_SHOPPING_LANGUAGE']);
    }
}
