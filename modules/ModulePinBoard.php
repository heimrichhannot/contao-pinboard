<?php

namespace HeimrichHannot\PinBoard;

use HeimrichHannot\FrontendEdit\ModuleList;
use HeimrichHannot\Haste\DateUtil;
use HeimrichHannot\Haste\Util\Arrays;
use HeimrichHannot\YouTube\YouTubeVideo;

class ModulePinBoard extends ModuleList
{
    protected $strTemplate     = 'mod_pinboard';
    protected $strWrapperId    = 'pinboard_';
    protected $strWrapperClass = 'frontendedit-list pinboard';

    public function generate()
    {
        if (TL_MODE == 'BE')
        {
            $objTemplate           = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD'][$this->type][0] ?: $this->type) . ' ###';
            $objTemplate->title    = $this->headline;
            $objTemplate->id       = $this->id;
            $objTemplate->link     = $this->name;
            $objTemplate->href     = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        return parent::generate();
    }

    protected function runBeforeTemplateParsing($objTemplate, $arrItem)
    {
        $objTemplate->ago          = DateUtil::getTimeElapsed($arrItem['raw']['date']);
        $objTemplate->commentCount = \CommentsModel::countPublishedBySourceAndParent('tl_news', $arrItem['fields']['id']);
        $objTemplate->isAuthor     = ($arrItem['raw']['memberAuthor'] == \FrontendUser::getInstance()->id);
        $this->imgSize             = deserialize($this->imgSize, true);

        if ($objTemplate->isAuthor && !$arrItem['raw']['published'])
        {
            $objTemplate->unpublished = true;
        }

        // media
        $strMedia = '';

        if ($arrItem['raw']['mediaType'] == 'video')
        {
            $arrItem['fields']['addYouTube'] = true;
            $arrItem['fields']['youtube']    = preg_replace('@.*watch\?v=([^&]+).*@i', '$1', $arrItem['fields']['pinBoardYouTube']);
            $objYouTube                      = YouTubeVideo::getInstance()->setData($arrItem['fields']);

            $strMedia = $objYouTube->getCachedYouTubePreviewImage();
        }
        elseif ($arrItem['raw']['pinBoardImage'])
        {
            $strMedia = $arrItem['fields']['pinBoardImage'];
        }

        if ($strMedia)
        {
            $objTemplate->media = \Image::get(str_replace(\Environment::get('url'), '', $strMedia), $this->imgSize[0], $this->imgSize[1], $this->imgSize[2]);
            $arrSize            = getimagesize(urldecode(TL_ROOT . '/' . $objTemplate->media));

            if (count($arrSize) > 1)
            {
                $objTemplate->imgSizeParsed = 'width="' . $arrSize[0] . '" height="' . $arrSize[1] . '"';
            }
        }
    }
}