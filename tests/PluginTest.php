<?php

namespace ArvGoogleCertifiedShops\Tests;

use ArvGoogleCertifiedShops\ArvGoogleCertifiedShops as Plugin;
use Shopware\Components\Test\Plugin\TestCase;

class PluginTest extends TestCase
{
    protected static $ensureLoadedPlugins = [
        'ArvGoogleCertifiedShops' => []
    ];

    public function testCanCreateInstance()
    {
        /** @var Plugin $plugin */
        $plugin = Shopware()->Container()->get('kernel')->getPlugins()['ArvGoogleCertifiedShops'];

        $this->assertInstanceOf(Plugin::class, $plugin);
    }
}
