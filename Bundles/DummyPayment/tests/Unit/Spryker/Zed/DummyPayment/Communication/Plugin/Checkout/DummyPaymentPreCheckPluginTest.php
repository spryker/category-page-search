<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Unit\Spryker\Zed\DummyPayment\Communication\Plugin\Checkout;

use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\DummyPayment\Communication\Plugin\Checkout\DummyPaymentPreCheckPlugin;

/**
 * @group Spryker
 * @group Zed
 * @group DummyPayment
 * @group Communication
 * @group DummyPaymentPostCheckPlugin
 */
class DummyPaymentPreCheckPluginTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @return void
     */
    public function testExecuteShouldReturnCheckoutResponseTransfer()
    {
        $checkoutResponseTransfer = new CheckoutResponseTransfer();

        $plugin = new DummyPaymentPreCheckPlugin();
        $checkoutResponseTransfer = $plugin->execute(new QuoteTransfer(), $checkoutResponseTransfer);

        $this->assertInstanceOf(CheckoutResponseTransfer::class, $checkoutResponseTransfer);
    }

}