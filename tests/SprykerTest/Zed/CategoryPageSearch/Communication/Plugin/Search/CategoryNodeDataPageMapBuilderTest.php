<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\CategoryPageSearch\Communication\Plugin\Event\Listener;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\LocaleTransfer;
use Propel\Runtime\Map\TableMap;
use Spryker\Zed\CategoryPageSearch\Communication\Plugin\Search\CategoryNodeDataPageMapBuilder;
use Spryker\Zed\CategoryPageSearch\Persistence\CategoryPageSearchQueryContainer;
use Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilder;
use Spryker\Zed\Search\Business\SearchFacadeInterface;
use Spryker\Zed\Search\SearchDependencyProvider;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group CategoryPageSearch
 * @group Communication
 * @group Plugin
 * @group Event
 * @group Listener
 * @group CategoryNodeDataPageMapBuilderTest
 * Add your own group annotations below this line
 *
 * @property \SprykerTest\Zed\CategoryPageSearch\CategoryPageSearchCommunicationTester $tester
 */
class CategoryNodeDataPageMapBuilderTest extends Unit
{
    /**
     * @return void
     */
    public function testBuildPageMapWillReturnCorrectTransfer(): void
    {
        $query = new CategoryPageSearchQueryContainer();
        $categoryNodeDataPageMapBuilder = new CategoryNodeDataPageMapBuilder();
        $categoryNode = $query->queryCategoryNodeTree([1], 46)->orderByIdCategoryNode()->find()->getFirst();
        $pageMapTransfer = $categoryNodeDataPageMapBuilder->buildPageMap(new PageMapBuilder(), $categoryNode->toArray(TableMap::TYPE_FIELDNAME, true, [], true), (new LocaleTransfer())->setIdLocale(46));

        $this->assertSame(3, count($pageMapTransfer->getFullText()));
        $this->assertSame('Demoshop', $pageMapTransfer->getFullTextBoosted()[0]);
    }

    /**
     * @dataProvider canMapRawDataToSearchDataProvider
     *
     * @param array $inputData
     * @param array $expected
     * @param string $localeName
     * @param string $mapperName
     *
     * @return void
     */
    public function testCanTransformPageMapToDocumentByMapperName(array $inputData, array $expected, string $localeName, string $mapperName): void
    {
        // Arrange
        $this->tester->setDependency(SearchDependencyProvider::PLUGIN_SEARCH_PAGE_MAPS, [
            new CategoryNodeDataPageMapBuilder(),
        ]);
        $localeTransfer = new LocaleTransfer();
        $localeTransfer->setLocaleName($localeName);

        // Act
        $result = $this->getSearchFacade()->transformPageMapToDocumentByMapperName($inputData, $localeTransfer, $mapperName);

        // Assert
        $this->assertEquals($expected, $result);
    }

    /**
     * @return array
     */
    public function canMapRawDataToSearchDataProvider(): array
    {
        return require codecept_data_dir('Fixtures/SearchDataMap/transform_page_map_test_data_provider.php');
    }

    /**
     * @return \Spryker\Zed\Search\Business\SearchFacadeInterface
     */
    protected function getSearchFacade(): SearchFacadeInterface
    {
        return $this->tester->getLocator()->search()->facade();
    }
}
