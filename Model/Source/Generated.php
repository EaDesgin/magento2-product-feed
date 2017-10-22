<?php
/**
 * Copyright © 2017 EaDesign by Eco Active S.R.L. All rights reserved.
 * See LICENSE for license details.
 */

namespace Eadesigndev\Productfeed\Model\Source;


class Generated extends AbstractSource
{

//    /**
//     * Types
//     */
    const IS_NOT_GENERATED = 0;
    const IS_GENERATED = 1;
//
//    /**
//     * Prepare post's statuses.
//     *
//     * @return array
//     */
//    public function getAvailable()
//    {
//        echo '<pre>';
//        print_r('test');
//        exit();
//        return [
//            self::IS_NOT_GENERATED => __('Not generated feed'),
//            self::IS_GENERATED => __('Feed is generated')
//        ];
//    }

    /**
     * get options
     *
     * @return array
     */
    public function toOptionArray()
    {
//        $options = [
//            self::IS_NOT_GENERATED => __('Not generated feed'),
//            self::IS_GENERATED => __('Feed is generated')
//        ];
//
//        foreach ($this->options as $values) {
//            $options[] = [
//                'value' => $values['value'],
//                'label' => __($values['label'])
//            ];
//        }

        $options[] = [
            'value' => self::IS_NOT_GENERATED,
            'label' =>  __('Not generated feed')
        ];
        $options[] = [
            'value' => self::IS_GENERATED,
            'label' =>  __('Feed is generated')
        ];

//        echo '<pre>';
//        print_r($options);
//        exit();

        return $options;
    }


}