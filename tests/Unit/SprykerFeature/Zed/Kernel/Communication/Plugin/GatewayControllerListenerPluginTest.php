<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Unit\SprykerFeature\Zed\Kernel\Communication\Plugin;

use SprykerEngine\Shared\Transfer\TransferInterface;
use SprykerFeature\Zed\Application\Communication\Plugin\TransferObject\Repeater;
use SprykerFeature\Zed\Application\Communication\Plugin\TransferObject\TransferServer as CoreTransferServer;
use SprykerFeature\Zed\Kernel\Communication\Plugin\GatewayControllerListenerPlugin;
use Unit\SprykerFeature\Zed\Kernel\Communication\Plugin\Fixture\FilterControllerEvent;
use Unit\SprykerFeature\Zed\Kernel\Communication\Plugin\Fixture\GatewayController;
use Unit\SprykerFeature\Zed\Kernel\Communication\Plugin\Fixture\NotGatewayController;
use Unit\SprykerFeature\Zed\Kernel\Communication\Plugin\Fixture\Request;
use Unit\SprykerFeature\Zed\Kernel\Communication\Plugin\Fixture\TransferServer;

/**
 * @group SprykerFeature
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
    public function testWhenControllerIsGAtewayControllerAndOnlyOneTransferObjectIsGivenActionMustReturnRepsonse()
    {
        $transfer = $this->getTransferMock();
        $controllerCallable = $this->executeMockedListenerTest('goodAction', $transfer);

        $response = call_user_func($controllerCallable);
        $this->assertInstanceOf('Symfony\\Component\\HttpFoundation\\JsonResponse', $response);
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
        $this->assertInstanceOf('Symfony\\Component\\HttpFoundation\\JsonResponse', $response);

        $responseContent = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('infoMessages', $responseContent);
        $this->assertArrayHasKey('errorMessages', $responseContent);
        $this->assertArrayHasKey('successMessages', $responseContent);
        $this->assertArrayHasKey('success', $responseContent);
        $this->assertEquals([['message' => 'info']], $responseContent['infoMessages']);
        $this->assertEquals([['message' => 'error']], $responseContent['errorMessages']);
        $this->assertEquals([['message' => 'success']], $responseContent['successMessages']);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Repeater
     */
    private function createRepeaterMock()
    {
        return $this->getMockBuilder('SprykerFeature\Zed\Application\Communication\Plugin\TransferObject\Repeater')
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @param TransferInterface $transferObject
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
     * @param $oldTransferServer
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
     * @param TransferInterface $transfer
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
     * @return \PHPUnit_Framework_MockObject_MockObject|TransferInterface
     */
    private function getTransferMock()
    {
        $transfer = $this->getMock('SprykerEngine\Shared\Transfer\TransferInterface');

        return $transfer;
    }

}
