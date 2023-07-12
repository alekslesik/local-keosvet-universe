<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use intec\core\collections\Arrays;

/**
 * @var array $arCurrentValues
 */

if (!Loader::includeModule('intec.core'))
    return;

if (!Loader::includeModule('iblock'))
    return;

$arTemplateParameters = [];

$arTemplateParameters['SETTINGS_USE'] = [
    'PARENT' => 'BASE',
    'NAME' => Loc::getMessage('C_MAIN_REVIEW_TEMPLATE_4_SETTINGS_USE'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N',
    'REFRESH' => 'Y'
];

if ($arCurrentValues['SETTINGS_USE'] !== 'Y') {
    $arTemplateParameters['LAZYLOAD_USE'] = [
        'PARENT' => 'BASE',
        'NAME' => Loc::getMessage('C_MAIN_REVIEW_TEMPLATE_4_LAZYLOAD_USE'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N'
    ];
}

if ($arCurrentValues['IBLOCK_ID']) {
    $arProperties = Arrays::fromDBResult(CIBlockProperty::GetList(['SORT' => 'ASC'], [
        'ACTIVE' => 'Y',
        'IBLOCK_ID' => $arCurrentValues['IBLOCK_ID']
    ]))->indexBy('CODE');

    $hPropertyText = function ($key, $value) {
        if ($value['PROPERTY_TYPE'] == 'S' && $value['LIST_TYPE'] == 'L' && $value['MULTIPLE'] === 'N')
            return [
                'key' => $key,
                'value' => '['.$key.'] '.$value['NAME']
            ];

        return ['skip' => true];
    };

    $arPropertyText = $arProperties->asArray($hPropertyText);

    $arTemplateParameters['PROPERTY_POSITION'] = [
        'PARENT' => 'DATA_SOURCE',
        'NAME' => Loc::getMessage('C_MAIN_REVIEW_TEMPLATE_4_PROPERTY_POSITION'),
        'TYPE' => 'LIST',
        'VALUES' => $arPropertyText,
        'ADDITIONAL_VALUES' => 'Y',
        'REFRESH' => 'Y'
    ];
}

$arTemplateParameters['LINK_USE'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_MAIN_REVIEW_TEMPLATE_4_LINK_USE'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N',
    'REFRESH' => 'Y'
];

if ($arCurrentValues['LINK_USE'] === 'Y') {
    $arTemplateParameters['LINK_BLANK'] = [
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_MAIN_REVIEW_TEMPLATE_4_LINK_BLANK'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N'
    ];
}

$arTemplateParameters['PREVIEW_TRUNCATE_USE'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_MAIN_REVIEW_TEMPLATE_4_PREVIEW_TRUNCATE_USE'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N',
    'REFRESH' => 'Y'
];

if ($arCurrentValues['PREVIEW_TRUNCATE_USE'] === 'Y') {
    $arTemplateParameters['PREVIEW_TRUNCATE_WORDS'] = [
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_MAIN_REVIEW_TEMPLATE_4_PREVIEW_TRUNCATE_WORDS'),
        'TYPE' => 'STRING',
        'DEFAULT' => 40
    ];
}

if (!empty($arCurrentValues['IBLOCK_ID']) && !empty($arCurrentValues['PROPERTY_POSITION'])) {
    $arTemplateParameters['POSITION_SHOW'] = [
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_MAIN_REVIEW_TEMPLATE_4_POSITION_SHOW'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N'
    ];
}

$arTemplateParameters['FOOTER_BUTTON_SHOW'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('C_MAIN_REVIEW_TEMPLATE_4_FOOTER_BUTTON_SHOW'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N',
    'REFRESH' => 'Y'
];

if ($arCurrentValues['FOOTER_BUTTON_SHOW'] === 'Y') {
    $arTemplateParameters['FOOTER_BUTTON_TEXT'] = [
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('C_MAIN_REVIEW_TEMPLATE_4_FOOTER_BUTTON_TEXT'),
        'TYPE' => 'STRING',
        'DEFAULT' => Loc::getMessage('C_MAIN_REVIEW_TEMPLATE_4_FOOTER_BUTTON_TEXT_DEFAULT')
    ];
}

if (!empty($arCurrentValues['IBLOCK_ID'])) {
    include(__DIR__ . '/parameters/send.php');
}