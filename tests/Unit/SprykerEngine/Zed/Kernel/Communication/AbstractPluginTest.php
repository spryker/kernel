<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Unit\SprykerEngine\Zed\Kernel\Communication;

use SprykerEngine\Zed\Kernel\AbstractUnitTest;
use SprykerEngine\Zed\Kernel\Business\AbstractFacade;
use SprykerEngine\Zed\Kernel\Communication\AbstractCommunicationDependencyContainer;
use SprykerEngine\Zed\Kernel\Communication\Factory;
use SprykerEngine\Zed\Kernel\Communication\PluginLocator;
use SprykerEngine\Zed\Kernel\Locator;
use SprykerEngine\Zed\Kernel\Persistence\AbstractQueryContainer;
use Unit\SprykerEngine\Zed\Kernel\Communication\Fixtures\AbstractPlugin\Plugin\FooPlugin;

/**
 * @group SprykerEngine
 * @group Zed
 * @group Kernel
 * @group Communication
 * @group AbstractPlugin
 */
class AbstractPluginTest extends AbstractUnitTest
{

    /**
     * @return void
     */
    public function testGetDependencyContainerShouldReturnNullIfNotSet()
    {
        $plugin = $this->getPlugin();
        $dependencyContainer = $plugin->getDependencyContainer();

        $this->assertNull($dependencyContainer);
    }

    /**
     * @return void
     */
    public function testGetDependencyContainerShouldReturnInstanceIfSet()
    {
        $plugin = $this->getPlugin();
        $plugin->setDependencyContainer($this->getDependencyContainerMock());
        $dependencyContainer = $plugin->getDependencyContainer();

        $this->assertInstanceOf(
            'SprykerEngine\Zed\Kernel\Communication\AbstractCommunicationDependencyContainer',
            $dependencyContainer
        );
    }

    /**
     * @return void
     */
    public function testGetFacadeShouldReturnNullIfNotSet()
    {
        $plugin = $this->getPlugin();
        $facade = $plugin->getFacade();

        $this->assertNull($facade);
    }

    /**
     * @return void
     */
    public function testGetFacadeShouldReturnInstanceIfSet()
    {
        $plugin = $this->getPlugin();
        $plugin->setOwnFacade($this->getFacadeMock());
        $facade = $plugin->getFacade();

        $this->assertInstanceOf('SprykerEngine\Zed\Kernel\Business\AbstractFacade', $facade);
    }

    /**
     * @return void
     */
    public function testGetQueryContainerShouldReturnNullIfNoQueryContainerIsSet()
    {
        $plugin = $this->getPlugin();
        $queryContainer = $plugin->getQueryContainer();

        $this->assertNull($queryContainer);
    }

    /**
     * @return void
     */
    public function testGetQueryContainerShouldReturnInstanceIfQueryContainerIsSet()
    {
        $plugin = $this->getPlugin();
        $plugin->setQueryContainer($this->getQueryContainerMock());
        $queryContainer = $plugin->getQueryContainer();

        $this->assertInstanceOf('SprykerEngine\Zed\Kernel\Persistence\AbstractQueryContainer', $queryContainer);
    }

    /**
     * @return AbstractCommunicationDependencyContainer
     */
    private function getDependencyContainerMock()
    {
        return $this->getMock('SprykerEngine\Zed\Kernel\Communication\AbstractCommunicationDependencyContainer', [], [],
            '', false);
    }

    /**
     * @return AbstractFacade
     */
    private function getFacadeMock()
    {
        return $this->getMock('SprykerEngine\Zed\Kernel\Business\AbstractFacade', [], [], '', false);
    }

    /**
     * @return AbstractQueryContainer
     */
    private function getQueryContainerMock()
    {
        return $this->getMock('SprykerEngine\Zed\Kernel\Persistence\AbstractQueryContainer', [], [], '', false);
    }

    /**
     * @return FooPlugin
     */
    private function getPlugin()
    {
        $plugin = new FooPlugin(new Factory('Kernel'), Locator::getInstance());

        return $plugin;
    }

    /**
     * @return FooPlugin
     */
    private function locatePlugin()
    {
        $locator = new PluginLocator(
            '\\Unit\\SprykerEngine\\Zed\\{{bundle}}{{store}}\\Communication\\Fixtures\\AbstractPlugin\\Factory'
        );

        $plugin = $locator->locate('Kernel', Locator::getInstance(), 'FooPlugin');

        return $plugin;
    }

}
