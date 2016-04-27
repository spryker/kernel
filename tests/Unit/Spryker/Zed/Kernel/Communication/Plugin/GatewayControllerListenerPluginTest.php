<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Unit\Spryker\Zed\Kernel\Communication\Plugin;

use Spryker\Shared\Kernel\AbstractLocatorLocator;
use Spryker\Shared\Transfer\TransferInterface;
use Spryker\Zed\Application\Communication\Plugin\TransferObject\Repeater;
use Spryker\Zed\Application\Communication\Plugin\TransferObject\TransferServer as CoreTransferServer;
use Spryker\Zed\Kernel\Communication\Plugin\GatewayControllerListenerPlugin;
use Symfony\Component\HttpFoundation\JsonResponse;
use Unit\Spryker\Zed\Kernel\Communication\Plugin\Fixture\FilterControllerEvent;
use Unit\Spryker\Zed\Kernel\Communication\Plugin\Fixture\GatewayController;
use Unit\Spryker\Zed\Kernel\Communication\Plugin\Fixture\NotGatewayController;
use Unit\Spryker\Zed\Kernel\Communication\Plugin\Fixture\Request;
use Unit\Spryker\Zed\Kernel\Communication\Plugin\Fixture\TransferServer;

/**
 * @group Spryker
 * @group Zed
 * @group Kernel
 * @group Communication
 * @group GatewayControllerListenerPlugin
 */
class GatewayControllerListenerPluginTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->unsetLocator();
    }

    /**
     * We need to unset the Locator instance because we are using the Locator for Yves and for Zed
     * When it first get instantiated by Yves it wont have the proper Proxies configured
     *
     * @return void
     */
    protected function unsetLocator()
    {
        $reflectionClass = new \ReflectionClass(AbstractLocatorLocator::class);
        $reflectedProperty = $reflectionClass->getProperty('instance');
        $reflectedProperty->setAccessible(true);
        $reflectedProperty->setValue(null);
    }

    /**
     * @return void
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->resetTransferServer();
    }

    /**
     * @return void
     */
    public function testWhenControllerIsGatewayControllerPluginMustReturnInstanceOfClosure()
    {
        $eventMock = new FilterControllerEvent();
        $controller = new GatewayController();
        $action = 'goodAction';
        $eventMock->setController([$controller, $action]);

        $controllerListenerPlugin = new GatewayControllerListenerPlugin();
        $controllerListenerPlugin->onKernelController($eventMock);

        $controllerCallable = $eventMock->getController();
        $this->assertTrue(is_callable($controllerCallable));
        $this->assertInstanceOf('\Closure', $controllerCallable);
    }

    /**
     * @return void
     */
    public function testWhenControllerIsNotAGatewayControllerPluginMustReturnPassedCallable()
    {
        $action = 'badAction';
        $eventMock = new FilterControllerEvent();
        $controller = new NotGatewayController();
        $eventMock->setController([$controller, $action]);

        $controllerListenerPlugin = new GatewayControllerListenerPlugin();
        $controllerListenerPlugin->onKernelController($eventMock);

        $controllerCallable = $eventMock->getController();
        $this->assertTrue(is_callable($controllerCallable));
        $this->assertNotInstanceOf('\Closure', $controllerCallable);
    }

    /**
     * @return void
     */
    public function testIfTwoTransferParameterGivenPluginMustThrowException()
    {
        $this->setExpectedException('\LogicException', 'Only one transfer object can be received in yves-action');

        $action = 'twoTransferParametersAction';
        $controllerCallable = $this->executeMockedListenerTest($action);
        call_user_func($controllerCallable);
    }

    /**
     * @return void
     */
    public function testIfTooManyTransferParameterGivenPluginMustThrowException()
    {
        $this->setExpectedException('\LogicException', 'Only one transfer object can be received in yves-action');

        $action = 'tooManyParametersAction';
        $controllerCallable = $this->executeMockedListenerTest($action);
        call_user_func($controllerCallable);
    }

    /**
     * @return void
     */
    public function testIfPassedParameterIsNotAClassPluginMustThrowException()
    {
        $this->setExpectedException('\LogicException', 'You need to specify a class for the parameter in the yves-action.');

        $action = 'noClassParameterAction';
        $controllerCallable = $this->executeMockedListenerTest($action);
        call_user_func($controllerCallable);
    }

    /**
     * @return void
     */
    public function testWhenObjectIsNotTransferClassPluginMustThrowException()
    {
        $this->setExpectedException('\LogicException', 'Only transfer classes are allowed in yves action as parameter');

        $transfer = new \StdClass();
        $controllerCallable = $this->executeMockedListenerTest('notTransferAction', $transfer);
        call_user_func($controllerCallable);
    }

    /**
     * @return void
     */
    public function testWhenControllerIsGatewayControllerAndOnlyOneTransferObjectIsGivenActionMustReturnResponse()
    {
        $transfer = $this->getTransferMock();
        $controllerCallable = $this->executeMockedListenerTest('goodAction', $transfer);

        $response = call_user_func($controllerCallable);
        $this->assertInstanceOf(JsonResponse::class, $response);
    }

    /**
     * @return void
     */
    public function testTransformMessagesFromController()
    {
        $action = 'transformMessageAction';

        $transfer = $this->getTransferMock();
        $controllerCallable = $this->executeMockedListenerTest($action, $transfer);

        $response = call_user_func($controllerCallable);
        $this->assertInstanceOf(JsonResponse::class, $response);

        $responseContent = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('infoMessages', $responseContent);
        $this->assertArrayHasKey('errorMessages', $responseContent);
        $this->assertArrayHasKey('successMessages', $responseContent);
        $this->assertArrayHasKey('success', $responseContent);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Spryker\Zed\Application\Communication\Plugin\TransferObject\Repeater
     */
    private function createRepeaterMock()
    {
        return $this->getMockBuilder(Repeater::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @param \Spryker\Shared\Transfer\TransferInterface $transferObject
     *
     * @return void
     */
    private function initTransferServer($transferObject)
    {
        $oldTransferServer = CoreTransferServer::getInstance();
        $this->resetSingleton($oldTransferServer);

        $request = new Request();
        $request->setFixtureTransfer($transferObject);
        TransferServer::getInstance()->setFixtureRequest($request);
    }

    /**
     * @return void
     */
    private function resetTransferServer()
    {
        $fixtureServer = TransferServer::getInstance();
        $this->resetSingleton($fixtureServer);
        CoreTransferServer::getInstance(
            $this->createRepeaterMock()
        );
    }

    /**
     * @param \Spryker\Shared\Transfer\TransferInterface $oldTransferServer
     *
     * @return void
     */
    private function resetSingleton($oldTransferServer)
    {
        $refObject = new \ReflectionObject($oldTransferServer);
        $refProperty = $refObject->getProperty('instance');
        $refProperty->setAccessible(true);
        $refProperty->setValue(null);
    }

    /**
     * @param string $action
     * @param \Spryker\Shared\Transfer\TransferInterface|null $transfer
     *
     * @return callable
     */
    private function executeMockedListenerTest($action, $transfer = null)
    {
        $eventMock = new FilterControllerEvent();
        $controller = new GatewayController();
        $eventMock->setController([$controller, $action]);

        $controllerListenerPlugin = new GatewayControllerListenerPlugin();

        if (!$transfer) {
            $transfer = $this->getTransferMock();
        }

        $this->initTransferServer($transfer);

        $controllerListenerPlugin->onKernelController($eventMock);
        $controllerCallable = $eventMock->getController();

        return $controllerCallable;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Spryker\Shared\Transfer\TransferInterface
     */
    private function getTransferMock()
    {
        $transfer = $this->getMock(TransferInterface::class);

        return $transfer;
    }

}
