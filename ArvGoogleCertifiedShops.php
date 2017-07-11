<?php

namespace ArvGoogleCertifiedShops;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\UpdateContext;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Shopware-Plugin ArvGoogleCertifiedShops.
 */
class ArvGoogleCertifiedShops extends Plugin
{

    /**
    * @param ContainerBuilder $container
    */
    public function build(ContainerBuilder $container)
    {
        $container->setParameter('arv_google_certified_shops_new.plugin_dir', $this->getPath());
        parent::build($container);
    }

    /**
     * @param UpdateContext $context
     */
    public function update(UpdateContext $context)
    {
        // Remove update zip if it exists
        $updateFile = __DIR__ . '/ArvGoogleCertifiedShops.zip';
        if (file_exists($updateFile)) {
            unlink($updateFile);
        }

        parent::update($context);
    }


}
