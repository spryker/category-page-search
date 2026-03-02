<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CategoryPageSearch;

use Spryker\Zed\CategoryPageSearch\Dependency\Facade\CategoryPageSearchToCategoryFacadeBridge;
use Spryker\Zed\CategoryPageSearch\Dependency\Facade\CategoryPageSearchToEventBehaviorFacadeBridge;
use Spryker\Zed\CategoryPageSearch\Dependency\Facade\CategoryPageSearchToStoreFacadeBridge;
use Spryker\Zed\CategoryPageSearch\Dependency\QueryContainer\CategoryPageSearchToCategoryQueryContainerBridge;
use Spryker\Zed\CategoryPageSearch\Dependency\Service\CategoryPageSearchToUtilEncodingBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

/**
 * @method \Spryker\Zed\CategoryPageSearch\CategoryPageSearchConfig getConfig()
 */
class CategoryPageSearchDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const QUERY_CONTAINER_CATEGORY = 'QUERY_CONTAINER_CATEGORY';

    /**
     * @var string
     */
    public const FACADE_CATEGORY = 'FACADE_CATEGORY';

    /**
     * @var string
     */
    public const FACADE_EVENT_BEHAVIOR = 'FACADE_EVENT_BEHAVIOR';

    /**
     * @var string
     */
    public const FACADE_STORE = 'FACADE_STORE';

    /**
     * @var string
     */
    public const SERVICE_UTIL_ENCODING = 'SERVICE_UTIL_ENCODING';

    public const string PLUGINS_CATEGORY_NODE_PAGE_SEARCH_DATA_EXPANDER = 'PLUGINS_CATEGORY_NODE_PAGE_SEARCH_DATA_EXPANDER';

    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);
        $container = $this->addEventBehaviorFacade($container);
        $container = $this->addStoreFacade($container);
        $container = $this->addCategoryFacade($container);

        return $container;
    }

    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);
        $container = $this->addStoreFacade($container);
        $container = $this->addCategoryFacade($container);
        $container = $this->addEventBehaviorFacade($container);
        $container = $this->addCategoryNodePageSearchDataExpanderPlugins($container);

        return $container;
    }

    public function providePersistenceLayerDependencies(Container $container): Container
    {
        $container = parent::providePersistenceLayerDependencies($container);
        $container = $this->addCategoryQueryContainer($container);
        $container = $this->addUtilEncodingService($container);

        return $container;
    }

    protected function addEventBehaviorFacade(Container $container): Container
    {
        $container->set(static::FACADE_EVENT_BEHAVIOR, function (Container $container) {
            return new CategoryPageSearchToEventBehaviorFacadeBridge($container->getLocator()->eventBehavior()->facade());
        });

        return $container;
    }

    protected function addStoreFacade(Container $container): Container
    {
        $container->set(static::FACADE_STORE, function (Container $container) {
            return new CategoryPageSearchToStoreFacadeBridge($container->getLocator()->store()->facade());
        });

        return $container;
    }

    protected function addCategoryFacade(Container $container): Container
    {
        $container->set(static::FACADE_CATEGORY, function (Container $container) {
            return new CategoryPageSearchToCategoryFacadeBridge($container->getLocator()->category()->facade());
        });

        return $container;
    }

    protected function addUtilEncodingService(Container $container): Container
    {
        $container->set(static::SERVICE_UTIL_ENCODING, function (Container $container) {
            return new CategoryPageSearchToUtilEncodingBridge($container->getLocator()->utilEncoding()->service());
        });

        return $container;
    }

    protected function addCategoryQueryContainer(Container $container): Container
    {
        $container->set(static::QUERY_CONTAINER_CATEGORY, function (Container $container) {
            return new CategoryPageSearchToCategoryQueryContainerBridge($container->getLocator()->category()->queryContainer());
        });

        return $container;
    }

    protected function addCategoryNodePageSearchDataExpanderPlugins(Container $container): Container
    {
        $container->set(static::PLUGINS_CATEGORY_NODE_PAGE_SEARCH_DATA_EXPANDER, function () {
            return $this->getCategoryNodePageSearchDataExpanderPlugins();
        });

        return $container;
    }

    /**
     * @return array<\Spryker\Zed\CategoryPageSearchExtension\Dependency\Plugin\CategoryNodePageSearchDataExpanderPluginInterface>
     */
    protected function getCategoryNodePageSearchDataExpanderPlugins(): array
    {
        return [];
    }
}
