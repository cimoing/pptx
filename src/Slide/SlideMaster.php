<?php

namespace Imoing\Pptx\Slide;

use Imoing\Pptx\Dml\Color\ColorFormat;
use Imoing\Pptx\Enum\MsoThemeColorIndex;
use Imoing\Pptx\OXml\Slide\CTSlideMaster;
use Imoing\Pptx\Parts\Slide\SlideMasterPart;
use Imoing\Pptx\Parts\Theme\OfficeStyleSheetPart;
use Imoing\Pptx\Shapes\Base\Theme;

/**
 * @property CTSlideMaster $_element
 * @property-read SlideLayouts $slideLayouts
 * @property-read SlideMasterPart $part
 * @property-read Theme $theme
 */
class SlideMaster extends BaseMaster
{
    private ?SlideLayouts $_layouts = null;
    public function getSlideLayouts(): SlideLayouts
    {
        if (null === $this->_layouts) {
            $this->_layouts = new SlideLayouts($this->_element->get_or_add_sldLayoutIdLst(), $this);
        }
        return $this->_layouts;
    }

    public function getThemePart(): OfficeStyleSheetPart
    {
        return $this->part->getThemePart();
    }

    private ?Theme $_theme = null;
    protected function getTheme(): Theme
    {
        if (null === $this->_theme) {
            $part = $this->getThemePart();
            $theme = new Theme($part->element,$part);
            $theme = $theme->withClrMap($this->_element->clrMap);
            $this->_theme = $theme;
        }

        return $this->_theme;
    }
}