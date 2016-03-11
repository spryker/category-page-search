<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Calculation\Business\Model;

use Generated\Shared\Transfer\CheckoutErrorTransfer;
use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Shared\Checkout\CheckoutConstants;

class CheckoutGrandTotalPreCondition implements CheckoutGrandTotalPreConditionInterface
{

    /**
     * @var \Spryker\Zed\Calculation\Business\Model\StackExecutorInterface
     */
    protected $stackExecutor;

    /**
     * @param \Spryker\Zed\Calculation\Business\Model\StackExecutorInterface $stackExecutor
     */
    public function __construct(StackExecutorInterface $stackExecutor)
    {
        $this->stackExecutor = $stackExecutor;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponseTransfer
     *
     * @return void
     */
    public function validateCheckoutGrandTotal(
        QuoteTransfer $quoteTransfer,
        CheckoutResponseTransfer $checkoutResponseTransfer
    ) {
        $totalsBefore = $quoteTransfer->getTotals()->getGrandTotal();
        $this->stackExecutor->recalculate($quoteTransfer);
        $totalsAfter = $quoteTransfer->getTotals()->getGrandTotal();

        if ($totalsBefore !== $totalsAfter) {
            $error = $this->createCheckoutErrorTransfer();
            $error
                ->setErrorCode(CheckoutConstants::ERROR_CODE_CART_AMOUNT_DIFFERENT)
                ->setMessage('Checkout grand total changed.');

            $checkoutResponseTransfer->addError($error);
        }
    }

    /**
     * @return \Generated\Shared\Transfer\CheckoutErrorTransfer
     */
    protected function createCheckoutErrorTransfer()
    {
        return new CheckoutErrorTransfer();
    }

}
