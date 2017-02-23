<?php

namespace HeimrichHannot\PinBoard\Backend;

use HeimrichHannot\Haste\Util\Module as HastePlusModule;

class Module extends \Backend
{
    public function setDefaults(\DataContainer $objDc)
    {
        if (!$objDc->id)
            return;

        $objModule = \ModuleModel::findByPk($objDc->id);

        if (HastePlusModule::isSubModuleOf($objModule->type, 'HeimrichHannot\PinBoard\ModulePinBoard'))
        {
            $objModule->formHybridDataContainer = 'tl_news';
            $objModule->formHybridPalette       = 'pinboard';
            $objModule->showInitialResults      = true;
            $objModule->addDetailsCol           = true;
            $objModule->addMasonry              = true;
            $objModule->sortingMode             = OPTION_FORMHYBRID_SORTINGMODE_FIELD;

            if (!$objModule->itemSorting)
            {
                $objModule->itemSorting = 'date_desc';
            }

            if (!$objModule->updateDeleteConditions)
            {
                $objModule->updateDeleteConditions = deserialize(
                    [
                        [
                            'field' => 'memberAuthor',
                            'value' => '{{user::id}}'
                        ]
                    ]
                );
            }

            if (!$objModule->additionalWhereSql)
            {
                $objModule->additionalWhereSql = '(tl_news.published=1 OR tl_news.memberAuthor="{{user::id}}")';
            }

            $objModule->save();
        }

        if (HastePlusModule::isSubModuleOf(
            $objModule->type,
            'HeimrichHannot\PinBoard\ModulePinBoardEditor'
        )
        )
        {
            $objModule->formHybridDataContainer = 'tl_news';
            $objModule->formHybridPalette       = 'pinboard';

            if (!$objModule->updateDeleteConditions)
            {
                $objModule->updateDeleteConditions = serialize(
                    [
                        [
                            'field' => 'memberAuthor',
                            'value' => '{{user::id}}'
                        ]
                    ]
                );
            }

            if (!$objModule->formHybridDefaultValues)
            {
                $objModule->formHybridDefaultValues = serialize(
                    [
                        [
                            'field' => 'date',
                            'value' => '{{date::U}}',
                            'label' => ''
                        ],
                        [
                            'field' => 'time',
                            'value' => '{{date::U}}',
                            'label' => ''
                        ],
                        [
                            'field' => 'source',
                            'value' => 'default',
                            'label' => ''
                        ],
                        [
                            'field' => 'type',
                            'value' => 'pinboard',
                            'label' => ''
                        ],
                        [
                            'field' => 'memberAuthor',
                            'value' => '{{user::id}}',
                            'label' => ''
                        ],
                        [
                            'field' => 'useMemberAuthor',
                            'value' => true,
                            'label' => ''
                        ]
                    ]
                );
            }

            $objModule->save();
        }

        if (HastePlusModule::isSubModuleOf(
            $objModule->type,
            'HeimrichHannot\PinBoard\ModulePinBoardReader'
        )
        )
        {
            $objModule->formHybridDataContainer = 'tl_news';
            $objModule->formHybridPalette       = 'pinboard';

            if (!$objModule->itemTemplate)
            {
                $objModule->itemTemplate = 'formhybrid_reader_pinboard';
            }

            $objModule->save();
        }
    }

    public function modifyDca(\DataContainer $objDc)
    {
        $objModule = \ModuleModel::findByPk($objDc->id);
        $arrDca    = &$GLOBALS['TL_DCA']['tl_module'];

        if (\HeimrichHannot\Haste\Util\Module::isSubModuleOf(
            $objModule->type,
            'HeimrichHannot\PinBoard\ModulePinBoard'
        )
        )
        {
            $arrDca['fields']['jumpToCreate']['eval']['tl_class']       = 'w50 clr';
            $arrDca['fields']['createMemberGroups']['eval']['tl_class'] = 'w50 clr';

            $arrDca['fields']['jumpToEdit']['eval']['tl_class'] = 'w50';
        }

        if (\HeimrichHannot\Haste\Util\Module::isSubModuleOf(
            $objModule->type,
            'HeimrichHannot\PinBoard\ModulePinBoardEditor'
        )
        )
        {
            $arrDca['fields']['setPageTitle']['eval']['tl_class'] = 'w50 clr';
        }
    }
}