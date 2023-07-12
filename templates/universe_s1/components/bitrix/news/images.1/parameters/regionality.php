<?php if (!defined('B_PROLOG_INCLUDED') && B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use intec\core\collections\Arrays;
use intec\regionality\platform\iblock\properties\RegionProperty;

/**
 * @var array $arCurrentValues
 * @var boolean $iblockExists
 */

if (Loader::includeModule('intec.regionality')) {
    $arTemplateParameters['REGIONALITY_USE'] = [
        'PARENT' => 'BASE',
        'NAME' => Loc::getMessage('C_NEWS_IMAGES_1_REGIONALITY_USE'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N',
        'REFRESH' => 'Y'
    ];

    if ($arCurrentValues['REGIONALITY_USE'] === 'Y') {
        if (!empty($arCurrentValues['DETAIL_PRODUCTS_IBLOCK_ID'])) {
            $arProperties = Arrays::fromDBResult(CIBlockProperty::GetList([], [
                'ACTIVE' => 'Y',
                'IBLOCK_ID' => $arCurrentValues['DETAIL_PRODUCTS_IBLOCK_ID'],
                'PROPERTY_TYPE' => RegionProperty::PROPERTY_TYPE,
                'USER_TYPE' => RegionProperty::USER_TYPE
            ]))->asArray(function ($sKey, $arProperty) {
                return [
                    'key' => $arProperty['CODE'],
                    'value' => '['.$arProperty['CODE'].'] '.$arProperty['NAME']
                ];
            });

            $arTemplateParameters['REGIONALITY_FILTER_USE'] = [
                'PARENT' => 'BASE',
                'NAME' => Loc::getMessage('C_NEWS_IMAGES_1_REGIONALITY_FILTER_USE'),
                'TYPE' => 'CHECKBOX',
                'DEFAULT' => 'N',
                'REFRESH' => 'Y'
            ];

            if ($arCurrentValues['REGIONALITY_FILTER_USE'] === 'Y') {
                $arTemplateParameters['REGIONALITY_FILTER_PROPERTY'] = [
                    'PARENT' => 'DATA_SOURCE',
                    'NAME' => Loc::getMessage('C_NEWS_IMAGES_1_REGIONALITY_FILTER_PROPERTY'),
                    'TYPE' => 'LIST',
                    'VALUES' => $arProperties,
                    'ADDITIONAL_VALUES' => 'Y'
                ];

                $arTemplateParameters['REGIONALITY_FILTER_STRICT'] = [
                    'PARENT' => 'BASE',
                    'NAME' => Loc::getMessage('C_NEWS_IMAGES_1_REGIONALITY_FILTER_STRICT'),
                    'TYPE' => 'CHECKBOX',
                    'DEFAULT' => 'N'
                ];
            }
        }
    }
}