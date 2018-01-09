<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Store\Business\Model;

use Spryker\Zed\Store\Business\Model\Configuration\StoreConfigurationProviderInterface;
use Spryker\Zed\Store\Business\Model\Exception\StoreNotFoundException;
use Spryker\Zed\Store\Persistence\StoreQueryContainerInterface;

class StoreReader implements StoreReaderInterface
{
    /**
     * @var \Spryker\Zed\Store\Business\Model\Configuration\StoreConfigurationProviderInterface
     */
    protected $storeConfigurationProvider;

    /**
     * @var \Spryker\Zed\Store\Persistence\StoreQueryContainerInterface
     */
    protected $storeQueryContainer;

    /**
     * @var \Spryker\Zed\Store\Business\Model\StoreMapperInterface
     */
    protected $storeMapper;

    /**
     * @var \Generated\Shared\Transfer\StoreTransfer[]
     */
    protected static $storeCache = [];

    /**
     * @param \Spryker\Zed\Store\Business\Model\Configuration\StoreConfigurationProviderInterface $storeConfigurationProvider
     * @param \Spryker\Zed\Store\Persistence\StoreQueryContainerInterface $storeQueryContainer
     * @param \Spryker\Zed\Store\Business\Model\StoreMapperInterface $storeMapper
     */
    public function __construct(
        StoreConfigurationProviderInterface $storeConfigurationProvider,
        StoreQueryContainerInterface $storeQueryContainer,
        StoreMapperInterface $storeMapper
    ) {
        $this->storeConfigurationProvider = $storeConfigurationProvider;
        $this->storeQueryContainer = $storeQueryContainer;
        $this->storeMapper = $storeMapper;
    }

    /**
     * @return array
     */
    public function getAllStores()
    {
        $stores = $this->storeConfigurationProvider->getAllStoreNames();
        $storeCollection = $this->storeQueryContainer
            ->queryStoresByNames($stores)
            ->find();

        $allStores = [];
        foreach ($storeCollection as $storeEntity) {
            $allStores[] = $this->storeMapper->mapEntityToTransfer($storeEntity);
        }

        return $allStores;
    }

    /**
     * @return \Generated\Shared\Transfer\StoreTransfer
     */
    public function getCurrentStore()
    {
        $currentStore = $this->storeConfigurationProvider->getCurrentStoreName();
        if (isset(static::$storeCache[$currentStore])) {
            return static::$storeCache[$currentStore];
        }

        $storeEntity = $this->storeQueryContainer
            ->queryStoreByName($currentStore)
            ->findOne();

        $storeTransfer = $this->storeMapper->mapEntityToTransfer($storeEntity);

        static::$storeCache[$currentStore] = $storeTransfer;

        return $storeTransfer;
    }

    /**
     * @param int $idStore
     *
     * @throws \Spryker\Zed\Store\Business\Model\Exception\StoreNotFoundException
     *
     * @return \Generated\Shared\Transfer\StoreTransfer
     */
    public function getStoreById($idStore)
    {
        if (isset(static::$storeCache[$idStore])) {
            return static::$storeCache[$idStore];
        }

         $storeEntity = $this->storeQueryContainer
             ->queryStoreById($idStore)
             ->findOne();

        if (!$storeEntity) {
            throw new StoreNotFoundException(
                sprintf('Store with id "%s" not found!', $idStore)
            );
        }

        $storeTransfer = $this->storeMapper->mapEntityToTransfer($storeEntity);

        static::$storeCache[$idStore] = $storeTransfer;

        return $storeTransfer;
    }

    /**
     * @param string $storeName
     *
     * @throws \Spryker\Zed\Store\Business\Model\Exception\StoreNotFoundException
     *
     * @return \Generated\Shared\Transfer\StoreTransfer
     */
    public function getStoreByName($storeName)
    {
        if (isset(static::$storeCache[$storeName])) {
            return static::$storeCache[$storeName];
        }

        $storeEntity = $this->storeQueryContainer
            ->queryStoreByName($storeName)
            ->findOne();

        if (!$storeEntity) {
            throw new StoreNotFoundException(
                sprintf('Store with name "%s" not found!', $storeName)
            );
        }

        $storeTransfer = $this->storeMapper->mapEntityToTransfer($storeEntity);

        static::$storeCache[$storeName] = $storeTransfer;

        return $storeTransfer;
    }
}