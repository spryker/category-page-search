<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\ProductCategory\Business;

use Generated\Shared\Transfer\AbstractProductTransfer;
use Generated\Shared\Transfer\CategoryTransfer;
use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\NodeTransfer;
use Generated\Shared\Transfer\ProductCategoryTransfer;
use Propel\Runtime\Exception\PropelException;
use Spryker\Zed\Kernel\Business\AbstractFacade;
use Spryker\Zed\Product\Business\Exception\MissingProductException;
use Spryker\Zed\ProductCategory\Business\Exception\MissingCategoryNodeException;
use Spryker\Zed\ProductCategory\Business\Exception\ProductCategoryMappingExistsException;

/**
 * @property ProductCategoryDependencyContainer $dependencyContainer
 *
 * @method ProductCategoryDependencyContainer getDependencyContainer()
 * @method ProductCategoryManager createProductManager()
 */
class ProductCategoryFacade extends AbstractFacade
{

    /**
     * @param string $sku
     * @param string $categoryName
     * @param LocaleTransfer $locale
     *
     * @throws ProductCategoryMappingExistsException
     * @throws MissingProductException
     * @throws MissingCategoryNodeException
     * @throws PropelException
     *
     * @return int
     */
    public function createProductCategoryMapping($sku, $categoryName, LocaleTransfer $locale)
    {
        return $this->getDependencyContainer()
            ->createProductCategoryManager()
            ->createProductCategoryMapping($sku, $categoryName, $locale);
    }

    /**
     * @param string $sku
     * @param string $categoryName
     * @param LocaleTransfer $locale
     *
     * @return bool
     */
    public function hasProductCategoryMapping($sku, $categoryName, LocaleTransfer $locale)
    {
        return $this->getDependencyContainer()
            ->createProductCategoryManager()
            ->hasProductCategoryMapping($sku, $categoryName, $locale);
    }

    /**
     * @param AbstractProductTransfer $abstractProductTransfer
     *
     * @return ProductCategoryTransfer[]
     */
    public function getCategoriesByAbstractProduct(AbstractProductTransfer $abstractProductTransfer)
    {
        $entities = $this->getDependencyContainer()
            ->createProductCategoryManager()
            ->getCategoriesByAbstractProduct($abstractProductTransfer);

        return $this->getDependencyContainer()
            ->createProductCategoryTransferGenerator()
            ->convertProductCategoryCollection($entities);
    }

    /**
     * @param int $idCategory
     * @param array $productIdsToAssign
     *
     * @throws PropelException
     *
     * @return void
     */
    public function createProductCategoryMappings($idCategory, array $productIdsToAssign)
    {
        $this->getDependencyContainer()
            ->createProductCategoryManager()
            ->createProductCategoryMappings($idCategory, $productIdsToAssign);
    }

    /**
     * @param int $idCategory
     * @param array $productIdsToUnAssign
     *
     * @return void
     */
    public function removeProductCategoryMappings($idCategory, array $productIdsToUnAssign)
    {
        $this->getDependencyContainer()
            ->createProductCategoryManager()
            ->removeProductCategoryMappings($idCategory, $productIdsToUnAssign);
    }

    /**
     * @param int $idCategory
     * @param array $productOrderList
     *
     * @throws PropelException
     *
     * @return void
     */
    public function updateProductMappingsOrder($idCategory, array $productOrderList)
    {
        $this->getDependencyContainer()
            ->createProductCategoryManager()
            ->updateProductMappingsOrder($idCategory, $productOrderList);
    }

    /**
     * @param int $idCategory
     * @param $productPreConfig
     *
     * @return void
     */
    public function updateProductCategoryPreConfig($idCategory, array $productPreConfig)
    {
        $this->getDependencyContainer()
            ->createProductCategoryManager()
            ->updateProductMappingsPreConfig($idCategory, $productPreConfig);
    }

    /**
     * @param int $idCategory
     * @param LocaleTransfer $locale
     *
     * @return void
     */
    public function deleteCategoryRecursive($idCategory, LocaleTransfer $locale)
    {
        $this->getDependencyContainer()
            ->createProductCategoryManager()
            ->deleteCategoryRecursive($idCategory, $locale);
    }

    /**
     * @param NodeTransfer $sourceNode
     * @param NodeTransfer $destinationNode
     * @param LocaleTransfer $locale
     *
     * @return void
     */
    public function moveCategoryChildrenAndDeleteNode(NodeTransfer $sourceNode, NodeTransfer $destinationNode, LocaleTransfer $locale)
    {
        $this->getDependencyContainer()
            ->createProductCategoryManager()
            ->moveCategoryChildrenAndDeleteNode($sourceNode, $destinationNode, $locale);
    }

    /**
     * @param CategoryTransfer $categoryTransfer
     * @param NodeTransfer $categoryNodeTransfer
     * @param LocaleTransfer $localeTransfer
     *
     * @return int
     */
    public function addCategory(CategoryTransfer $categoryTransfer, NodeTransfer $categoryNodeTransfer, LocaleTransfer $localeTransfer)
    {
        return $this->getDependencyContainer()
            ->createProductCategoryManager()
            ->addCategory($categoryTransfer, $categoryNodeTransfer, $localeTransfer);
    }

    /**
     * @param int $idCategoryNode
     * @param int $fkParentCategoryNode
     * @param bool $deleteChildren
     * @param LocaleTransfer $localeTransfer
     *
     * @return void
     */
    public function deleteCategory($idCategoryNode, $fkParentCategoryNode, $deleteChildren, LocaleTransfer $localeTransfer)
    {
        $this->getDependencyContainer()
            ->createProductCategoryManager()
            ->deleteCategory($idCategoryNode, $fkParentCategoryNode, $deleteChildren, $localeTransfer);
    }

}