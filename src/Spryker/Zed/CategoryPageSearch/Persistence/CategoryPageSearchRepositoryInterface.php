<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CategoryPageSearch\Persistence;

interface CategoryPageSearchRepositoryInterface
{
    /**
     * Specification:
     * - Retrieves a collection of synchronization data according to provided offset, limit and ids.
     *
     * @api
     *
     * @param int $offset
     * @param int $limit
     * @param int[] $categoryNodeIds
     *
     * @return \Generated\Shared\Transfer\SynchronizationDataTransfer[]
     */
    public function findSynchronizationDataTransfersByIds(int $offset, int $limit, array $categoryNodeIds): array;
}
