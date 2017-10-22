<?php
/**
 * Copyright © 2017 EaDesign by Eco Active S.R.L. All rights reserved.
 * See LICENSE for license details.
 */

namespace Eadesigndev\Productfeed\Model;

use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider as DataProviderClass;

/**
 * Class DataProvider for the form area
 */
class DataProvider extends DataProviderClass
{

    /**
     * @param SearchResultInterface $searchResult
     * @return array
     */
    protected function searchResultToOutput(SearchResultInterface $searchResult)
    {
        $itemData = [];
        foreach ($searchResult->getItems() as $item) {
            foreach ($item->getCustomAttributes() as $attribute) {
                $itemData[$item->getData($this->primaryFieldName)][$attribute->getAttributeCode()] = $attribute->getValue();
            }
            $itemData;
        }

        return $itemData;
    }
}
