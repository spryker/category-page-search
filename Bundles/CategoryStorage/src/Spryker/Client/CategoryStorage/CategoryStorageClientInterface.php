<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\CategoryStorage;

use Generated\Shared\Transfer\CategoryNodeStorageTransfer;

interface CategoryStorageClientInterface
{
    /**
     * @param string $locale
     *
     * @return array
     */
    public function getCategories($locale);

    /**
     * @param int $idCategoryNode
     * @param string $localeName
     *
     * @return CategoryNodeStorageTransfer
     */
    public function getCategoryNodeById($idCategoryNode, $localeName);
}