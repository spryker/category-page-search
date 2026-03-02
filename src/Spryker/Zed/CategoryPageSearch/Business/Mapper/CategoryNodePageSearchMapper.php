<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CategoryPageSearch\Business\Mapper;

use Generated\Shared\Transfer\CategoryNodePageSearchTransfer;
use Generated\Shared\Transfer\NodeTransfer;
use Spryker\Zed\CategoryPageSearch\Business\Search\DataMapper\CategoryNodePageSearchDataMapperInterface;

class CategoryNodePageSearchMapper implements CategoryNodePageSearchMapperInterface
{
    /**
     * @var \Spryker\Zed\CategoryPageSearch\Business\Search\DataMapper\CategoryNodePageSearchDataMapperInterface
     */
    protected $categoryNodePageSearchDataMapperInterface;

    /**
     * @param \Spryker\Zed\CategoryPageSearch\Business\Search\DataMapper\CategoryNodePageSearchDataMapperInterface $categoryNodePageSearchDataMapperInterface
     * @param array<\Spryker\Zed\CategoryPageSearchExtension\Dependency\Plugin\CategoryNodePageSearchDataExpanderPluginInterface> $categoryNodePageSearchDataExpanderPlugins
     */
    public function __construct(
        CategoryNodePageSearchDataMapperInterface $categoryNodePageSearchDataMapperInterface,
        protected array $categoryNodePageSearchDataExpanderPlugins
    ) {
        $this->categoryNodePageSearchDataMapperInterface = $categoryNodePageSearchDataMapperInterface;
    }

    public function mapNodeTransferToCategoryNodePageSearchTransferForStoreAndLocale(
        NodeTransfer $nodeTransfer,
        CategoryNodePageSearchTransfer $categoryNodePageSearchTransfer,
        string $storeName,
        string $localeName
    ): CategoryNodePageSearchTransfer {
        $data = $this->categoryNodePageSearchDataMapperInterface->mapNodeTransferToCategoryNodePageSearchDataForStoreAndLocale(
            $nodeTransfer,
            $storeName,
            $localeName,
        );

        $data = $this->executeCategoryNodePageSearchDataExpanderPlugins($data, $nodeTransfer, $storeName, $localeName);

        return $categoryNodePageSearchTransfer
            ->setIdCategoryNode($nodeTransfer->getIdCategoryNode())
            ->setNode($nodeTransfer)
            ->setData($data)
            ->setStore($storeName)
            ->setLocale($localeName);
    }

    protected function executeCategoryNodePageSearchDataExpanderPlugins(
        array $data,
        NodeTransfer $nodeTransfer,
        string $storeName,
        string $localeName
    ): array {
        foreach ($this->categoryNodePageSearchDataExpanderPlugins as $categoryNodePageSearchDataExpanderPlugin) {
            $data = $categoryNodePageSearchDataExpanderPlugin->expandCategoryNodePageSearchData(
                $data,
                $nodeTransfer,
                $storeName,
                $localeName,
            );
        }

        return $data;
    }
}
