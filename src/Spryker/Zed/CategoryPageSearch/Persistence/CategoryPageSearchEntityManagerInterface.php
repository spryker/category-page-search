<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CategoryPageSearch\Persistence;

use Generated\Shared\Transfer\CategoryNodePageSearchTransfer;

interface CategoryPageSearchEntityManagerInterface
{
    public function saveCategoryNodePageSearch(CategoryNodePageSearchTransfer $categoryNodePageSearchTransfer): void;

    /**
     * @param array<int> $categoryNodeIds
     *
     * @return void
     */
    public function deleteCategoryNodePageSearchByCategoryNodeIds(array $categoryNodeIds): void;

    public function deleteCategoryNodePageSearchByIdCategoryNodeForLocaleAndStore(
        int $idCategoryNode,
        string $localeName,
        string $storeName
    ): void;
}
