<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace ClientUnit\SprykerFeature\Client\Cart\Service;

use Generated\Shared\Transfer\CartItemTransfer;
use Generated\Shared\Transfer\CartTransfer;
use SprykerEngine\Client\Kernel\Factory;
use SprykerEngine\Client\Kernel\Locator;
use SprykerFeature\Client\Cart\Service\CartClient;
use SprykerFeature\Client\Cart\Service\Session\CartSessionInterface;
use SprykerFeature\Client\Cart\Service\Storage\CartStorageInterface;
use SprykerFeature\Client\Cart\Service\Zed\CartStubInterface;

/**
 * @group SprykerFeature
 * @group Client
 * @group Cart
 * @group Service
 * @group CartClient
 */
class CartClientTest extends \PHPUnit_Framework_TestCase
{

    public function testGetCartMustReturnInstanceOfCartTransfer()
    {
        $cartTransfer = new CartTransfer();
        $sessionMock = $this->getSessionMock();
        $sessionMock->expects($this->once())
            ->method('getCart')
            ->will($this->returnValue($cartTransfer))
        ;

        $dependencyContainerMock = $this->getDependencyContainerMock($sessionMock);
        $cartClientMock = $this->getCartClientMock($dependencyContainerMock);

        $this->assertSame($cartTransfer, $cartClientMock->getCart());
    }

    public function testClearCartMustSetItemCountInSessionToZero()
    {
        $sessionMock = $this->getSessionMock();
        $sessionMock->expects($this->once())
            ->method('setItemCount')
            ->with(0)
            ->will($this->returnValue($sessionMock))
        ;

        $dependencyContainerMock = $this->getDependencyContainerMock($sessionMock);
        $cartClientMock = $this->getCartClientMock($dependencyContainerMock);

        $cartClientMock->clearCart();
    }

    public function testClearCartMustSetCartTransferInSessionToAnEmptyInstance()
    {
        $cartTransfer = new CartTransfer();
        $sessionMock = $this->getSessionMock();
        $sessionMock->expects($this->once())
            ->method('setItemCount')
            ->will($this->returnValue($sessionMock))
        ;

        $sessionMock->expects($this->once())
            ->method('setCart')
            ->with($cartTransfer)
            ->will($this->returnValue($sessionMock))
        ;

        $dependencyContainerMock = $this->getDependencyContainerMock($sessionMock);
        $cartClientMock = $this->getCartClientMock($dependencyContainerMock);

        $cartClientMock->clearCart();
    }

    public function testGetItemCountMustReturnItemCountFromSession()
    {
        $sessionMock = $this->getSessionMock();
        $sessionMock->expects($this->once())
            ->method('getItemCount')
            ->will($this->returnValue(0))
        ;

        $dependencyContainerMock = $this->getDependencyContainerMock($sessionMock);
        $cartClientMock = $this->getCartClientMock($dependencyContainerMock);

        $this->assertSame(0, $cartClientMock->getItemCount());
    }

    public function testAddItemMustOnlyExceptTransferInterfaceAsArgument()
    {
        $cartItemTransfer = new CartItemTransfer();
        $cartTransfer = new CartTransfer();
        $sessionMock = $this->getSessionMock();
        $sessionMock->expects($this->once())
            ->method('getCart')
            ->will($this->returnValue($cartTransfer))
        ;

        $stubMock = $this->getStubMock();
        $stubMock->expects($this->once())
            ->method('addItem')
            ->will($this->returnValue($cartTransfer))
        ;

        $dependencyContainerMock = $this->getDependencyContainerMock($sessionMock, $stubMock);
        $cartClientMock = $this->getCartClientMock($dependencyContainerMock);

        $cartTransfer = $cartClientMock->addItem($cartItemTransfer);

        $this->assertInstanceOf('Generated\Shared\Cart\CartInterface', $cartTransfer);
    }

    public function testRemoveItemMustOnlyExceptTransferInterfaceAsArgument()
    {
        $cartItemTransfer = new CartItemTransfer();
        $cartItemTransfer->setId('identifier');
        $cartTransfer = new CartTransfer();
        $cartTransfer->addItem($cartItemTransfer);

        $sessionMock = $this->getSessionMock();
        $sessionMock->expects($this->exactly(2))
            ->method('getCart')
            ->will($this->returnValue($cartTransfer))
        ;

        $stubMock = $this->getStubMock();
        $stubMock->expects($this->once())
            ->method('removeItem')
            ->will($this->returnValue($cartTransfer))
        ;

        $dependencyContainerMock = $this->getDependencyContainerMock($sessionMock, $stubMock);
        $cartClientMock = $this->getCartClientMock($dependencyContainerMock);

        $cartTransfer = $cartClientMock->removeItem($cartItemTransfer);

        $this->assertInstanceOf('Generated\Shared\Cart\CartInterface', $cartTransfer);
    }

    public function testChangeItemQuantityMustOnlyExceptTransferInterfaceAsArgument()
    {
        $cartItemTransfer = new CartItemTransfer();
        $cartItemTransfer->setQuantity(2);
        $cartItemTransfer->setId('identifier');

        $cartTransfer = new CartTransfer();
        $cartTransfer->addItem($cartItemTransfer);

        $sessionMock = $this->getSessionMock();
        $sessionMock->expects($this->exactly(3))
            ->method('getCart')
            ->will($this->returnValue($cartTransfer))
        ;

        $stubMock = $this->getStubMock();
        $stubMock->expects($this->once())
            ->method('decreaseItemQuantity')
            ->will($this->returnValue($cartTransfer))
        ;
        $stubMock->expects($this->never())
            ->method('increaseItemQuantity')
            ->will($this->returnValue($cartTransfer))
        ;

        $dependencyContainerMock = $this->getDependencyContainerMock($sessionMock, $stubMock);
        $cartClientMock = $this->getCartClientMock($dependencyContainerMock);

        $cartItemTransfer = new CartItemTransfer();
        $cartItemTransfer->setQuantity(1);
        $cartItemTransfer->setId('identifier');

        $cartTransfer = $cartClientMock->changeItemQuantity($cartItemTransfer);

        $this->assertInstanceOf('Generated\Shared\Cart\CartInterface', $cartTransfer);
    }

    public function testChangeItemQuantityMustCallDecreaseItemQuantityWhenPassedItemQuantityIsLowerThenInCartGivenItem()
    {
        $cartItemTransfer = new CartItemTransfer();
        $cartItemTransfer->setQuantity(2);
        $cartItemTransfer->setId('identifier');

        $cartTransfer = new CartTransfer();
        $cartTransfer->addItem($cartItemTransfer);

        $sessionMock = $this->getSessionMock();
        $sessionMock->expects($this->exactly(3))
            ->method('getCart')
            ->will($this->returnValue($cartTransfer))
        ;

        $stubMock = $this->getStubMock();
        $stubMock->expects($this->once())
            ->method('decreaseItemQuantity')
            ->will($this->returnValue($cartTransfer))
        ;
        $stubMock->expects($this->never())
            ->method('increaseItemQuantity')
            ->will($this->returnValue($cartTransfer))
        ;

        $dependencyContainerMock = $this->getDependencyContainerMock($sessionMock, $stubMock);
        $cartClientMock = $this->getCartClientMock($dependencyContainerMock);

        $cartItemTransfer = new CartItemTransfer();
        $cartItemTransfer->setQuantity(1);
        $cartItemTransfer->setId('identifier');

        $cartTransfer = $cartClientMock->changeItemQuantity($cartItemTransfer);

        $this->assertInstanceOf('Generated\Shared\Cart\CartInterface', $cartTransfer);
    }

    public function testChangeItemQuantityMustCallIncreaseItemQuantityWhenPassedItemQuantityIsLowerThenInCartGivenItem()
    {
        $cartItemTransfer = new CartItemTransfer();
        $cartItemTransfer->setQuantity(1);
        $cartItemTransfer->setId('identifier');

        $cartTransfer = new CartTransfer();
        $cartTransfer->addItem($cartItemTransfer);

        $sessionMock = $this->getSessionMock();
        $sessionMock->expects($this->exactly(3))
            ->method('getCart')
            ->will($this->returnValue($cartTransfer))
        ;

        $stubMock = $this->getStubMock();
        $stubMock->expects($this->never())
            ->method('decreaseItemQuantity')
            ->will($this->returnValue($cartTransfer))
        ;
        $stubMock->expects($this->once())
            ->method('increaseItemQuantity')
            ->will($this->returnValue($cartTransfer))
        ;

        $dependencyContainerMock = $this->getDependencyContainerMock($sessionMock, $stubMock);
        $cartClientMock = $this->getCartClientMock($dependencyContainerMock);

        $cartItemTransfer = new CartItemTransfer();
        $cartItemTransfer->setQuantity(2);
        $cartItemTransfer->setId('identifier');

        $cartTransfer = $cartClientMock->changeItemQuantity($cartItemTransfer);

        $this->assertInstanceOf('Generated\Shared\Cart\CartInterface', $cartTransfer);
    }

    /**
     * @param CartSessionInterface|null $cartSession
     * @param CartStubInterface|null $cartStub
     * @param CartStorageInterface|null $cartStorage
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getDependencyContainerMock(
        CartSessionInterface $cartSession = null,
        CartStubInterface $cartStub = null,
        CartStorageInterface $cartStorage = null
    ) {
        $dependencyContainerMock = $this->getMock(
            'SprykerEngine\Client\Kernel\Service\AbstractServiceDependencyContainer',
            ['createSession', 'createZedStub', 'createStorage'], [], '', false)
        ;

        if (!is_null($cartSession)) {
            $dependencyContainerMock->expects($this->any())
                ->method('createSession')
                ->will($this->returnValue($cartSession))
            ;
        }
        if (!is_null($cartStub)) {
            $dependencyContainerMock->expects($this->any())
                ->method('createZedStub')
                ->will($this->returnValue($cartStub))
            ;
        }
        if (!is_null($cartStorage)) {
            $dependencyContainerMock->expects($this->any())
                ->method('createStorage')
                ->will($this->returnValue($cartStorage))
            ;
        }

        return $dependencyContainerMock;
    }

    /**
     * @param $dependencyContainerMock
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|CartClient
     */
    private function getCartClientMock($dependencyContainerMock)
    {
        $cartClientMock = $this->getMock(
            'SprykerFeature\Client\Cart\Service\CartClient',
            ['getDependencyContainer'], [], '', false)
        ;

        $cartClientMock->expects($this->any())
            ->method('getDependencyContainer')
            ->will($this->returnValue($dependencyContainerMock));

        return $cartClientMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getSessionMock()
    {
        $sessionMock = $this->getMock('SprykerFeature\Client\Cart\Service\Session\CartSessionInterface', [
            'getCart',
            'setCart',
            'getItemCount',
            'setItemCount'
        ]);

        return $sessionMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|CartStubInterface
     */
    private function getStubMock()
    {
        return $this->getMock('SprykerFeature\Client\Cart\Service\Zed\CartStubInterface', [
            'addItem',
            'removeItem',
            'increaseItemQuantity',
            'decreaseItemQuantity',
            'addCoupon',
            'removeCoupon',
            'clearCoupons',
            'recalculate'
        ]);
    }

}