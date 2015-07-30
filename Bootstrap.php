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
     * Standard plugin install method to register all required components.
     *
     * @throws \Exception
     * @return bool
     */
    public function install()
    {


        return true;
    }

    /**
     * @return bool
     */
    public function uninstall()
    {
        return true;
    }
}