<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CategoryPageSearch\Dependency\Facade;

use Generated\Shared\Transfer\CategoryNodeCriteriaTransfer;
use Generated\Shared\Transfer\NodeCollectionTransfer;

interface CategoryPageSearchToCategoryFacadeInterface
{
    public function getCategoryNodes(CategoryNodeCriteriaTransfer $categoryNodeCriteriaTransfer): NodeCollectionTransfer;
}
