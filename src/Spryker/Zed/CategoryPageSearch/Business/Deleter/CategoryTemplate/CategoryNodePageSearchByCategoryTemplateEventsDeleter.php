<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CategoryPageSearch\Business\Deleter\CategoryTemplate;

use Generated\Shared\Transfer\CategoryNodeCriteriaTransfer;
use Spryker\Zed\CategoryPageSearch\Business\Deleter\CategoryNodePageSearchDeleterInterface;
use Spryker\Zed\CategoryPageSearch\Dependency\Facade\CategoryPageSearchToEventBehaviorFacadeInterface;

class CategoryNodePageSearchByCategoryTemplateEventsDeleter implements CategoryNodePageSearchByCategoryTemplateEventsDeleterInterface
{
    /**
     * @var \Spryker\Zed\CategoryPageSearch\Dependency\Facade\CategoryPageSearchToEventBehaviorFacadeInterface
     */
    protected $eventBehaviorFacade;

    /**
     * @var \Spryker\Zed\CategoryPageSearch\Business\Deleter\CategoryNodePageSearchDeleterInterface
     */
    protected $categoryNodePageSearchDeleter;

    /**
     * @param \Spryker\Zed\CategoryPageSearch\Dependency\Facade\CategoryPageSearchToEventBehaviorFacadeInterface $eventBehaviorFacade
     * @param \Spryker\Zed\CategoryPageSearch\Business\Deleter\CategoryNodePageSearchDeleterInterface $categoryNodePageSearchDeleter
     */
    public function __construct(
        CategoryPageSearchToEventBehaviorFacadeInterface $eventBehaviorFacade,
        CategoryNodePageSearchDeleterInterface $categoryNodePageSearchDeleter
    ) {
        $this->eventBehaviorFacade = $eventBehaviorFacade;
        $this->categoryNodePageSearchDeleter = $categoryNodePageSearchDeleter;
    }

    /**
     * @param array<\Generated\Shared\Transfer\EventEntityTransfer> $eventEntityTransfers
     *
     * @return void
     */
    public function deleteCategoryNodePageSearchCollectionByCategoryTemplateEvents(array $eventEntityTransfers): void
    {
        $categoryTemplateIds = $this->eventBehaviorFacade->getEventTransferIds($eventEntityTransfers);

        $this->categoryNodePageSearchDeleter->deleteCategoryNodeStorageCollectionByCategoryNodeCriteria(
            (new CategoryNodeCriteriaTransfer())->setCategoryTemplateIds($categoryTemplateIds),
        );
    }
}
