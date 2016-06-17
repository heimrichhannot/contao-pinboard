<?php

namespace HeimrichHannot\PinBoard;

use HeimrichHannot\FrontendEdit\ModuleReader;

class ModulePinBoardEditor extends ModuleReader
{
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new \BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### PINBOARD EDITOR ###';
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

		$this->objModel->formHybridAsync = true;
	}

	public function modifyDC(&$arrDca = null)
	{
		$arrDca['fields']['youtube']['label'] = $GLOBALS['TL_LANG']['tl_news']['youtubePinBoard'];
		$arrDca['fields']['youtube']['eval']['explanation'] = $GLOBALS['TL_LANG']['tl_news']['youtubeExplanation'];

		$arrDca['fields']['teaser']['label'] = $GLOBALS['TL_LANG']['tl_news']['teaserPinBoard'];
	}


}
