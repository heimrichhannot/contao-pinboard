<?php

namespace HeimrichHannot\PinBoard;

use HeimrichHannot\FormHybridList\ModuleReader;
use HeimrichHannot\YouTube\YouTubeVideo;

class ModulePinBoardReader extends ModuleReader
{
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new \BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### PINBOARD READER ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}

		$this->initialize();

		return parent::generate();
	}

	protected function initialize()
	{
		$this->formHybridDataContainer = $this->objModel->formHybridDataContainer = 'tl_news';
		$this->formHybridPalette = $this->objModel->formHybridPalette = 'default';
	}

	protected function runBeforeTemplateParsing($objTemplate, $objItem) {
		$this->imgSize = deserialize($this->imgSize, true);

		if ($objTemplate->isAuthor && !$objItem->raw['published'])
			$objTemplate->unpublished = true;

		// media
		$strMedia = '';

		if ($objItem->raw['mediaType'] == 'video')
		{
			$objItem->addYouTube = true;
			$objItem->youtube = preg_replace('@.*watch\?v=([^&]+).*@i', '$1', $objItem->pinBoardYouTube);
			$objYouTube = YouTubeVideo::getInstance()->setData($objItem->row());
			$objYouTube->autoplay = true;

			$strMedia = $objYouTube->generate();
		}
		elseif ($objItem->pinBoardImage)
		{
			$strMedia = $objItem->pinBoardImage;
		}

		if ($strMedia && $objItem->raw['mediaType'] == 'image')
		{
			$objTemplate->media = \Image::get($strMedia, $this->imgSize[0], $this->imgSize[1], $this->imgSize[2]);
			$arrSize = getimagesize(urldecode(TL_ROOT . '/' . $objTemplate->media));

			if (count($arrSize) > 1)
				$objTemplate->imgSizeParsed = 'width="' . $arrSize[0] . '" height="' . $arrSize[1] . '"';
		}
		else
		{
			$objTemplate->media = $strMedia;
		}
	}

}