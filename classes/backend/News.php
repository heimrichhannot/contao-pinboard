<?php

namespace HeimrichHannot\PinBoard\Backend;

use HeimrichHannot\Haste\Dca\General;

class News extends \Backend
{
    public static function modifyPalette()
    {
        $arrDca = &$GLOBALS['TL_DCA']['tl_news'];

        if (($objNews = \NewsModel::findByPk(\Input::get('id'))) !== null && $objNews->useMemberAuthor)
        {
            $arrDca['palettes']['pinboard'] = str_replace(',author', ',', $arrDca['palettes']['pinboard']);
        }
        else
        {
            $arrDca['palettes']['pinboard'] = str_replace(',memberAuthor', ',', $arrDca['palettes']['pinboard']);
        }
    }

    public static function generateAlias()
    {
        if (TL_MODE == 'FE')
        {
            if (($objNews = \NewsModel::findByPk(\Input::get('id'))) !== null && $objNews->type == 'pinboard')
            {
                $objNews->alias = General::generateAlias($objNews->alias, $objNews->id, 'tl_news', $objNews->headline);
                $objNews->save();
            }
        }
    }
}