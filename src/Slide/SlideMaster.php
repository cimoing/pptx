<?php

namespace Imoing\Pptx\Slide;

use Imoing\Pptx\Dml\Color\ColorFormat;
use Imoing\Pptx\Enum\MsoThemeColorIndex;
use Imoing\Pptx\OXml\Slide\CTSlideMaster;
use Imoing\Pptx\Parts\Slide\SlideMasterPart;
use Imoing\Pptx\Parts\Theme\OfficeStyleSheetPart;

/**
 * @property CTSlideMaster $_element
 * @property-read SlideLayouts $slideLayouts
 * @property-read SlideMasterPart $part
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

    private ?OfficeStyleSheet $_theme = null;
    public function getTheme(): OfficeStyleSheet
    {
        if (null === $this->_theme) {
            $part = $this->getThemePart();
            $this->_theme = new OfficeStyleSheet($part->element, $part);
        }
    }

    private ?array $_colorScheme = null;
    public function getColorScheme(): array
    {
        if (null === $this->_colorScheme) {
            $fallback = [
                'lt1' => 'FFFFFF',
                'dk1' => '000000',
                'accent1' => '4472C4',
                'accent2' => 'ED7D31',
                'accent3' => 'A5A5A5',
                'accent4' => 'FFC000',
                'accent5' => '772B01',
                'accent6' => 'ED7D31',
                'hlink' => '0563C1',
                'folHlink' => '954F72',
                'bg1' => 'FFFFFF',
                'bg2' => 'FFFFFF',
                'tx1' => '000000',
                'tx2' => '000000',
            ];
            $clrScheme = $this->getThemePart()->element->themeElements->clrScheme;
            $schemeNames = ['dk1', 'lt1', 'dk2', 'lt2', 'accent1', 'accent2', 'accent3', 'accent4', 'accent5', 'accent6', 'tx1', 'tx2', 'bg1', 'bg2', 'hlink', 'folHlink'];

            $colors = [];
            foreach ($schemeNames as $schemeName) {
                $color = $clrScheme->{$schemeName};
                if (null === $color) {
                    $colors[$schemeName] = $fallback[$schemeName];
                } else {
                    $colorFmt = ColorFormat::fromColorChoiceParent($color);
                    $colors[$schemeName] = (string) $colorFmt->getRgb();
                }
            }
            $this->_colorScheme = $colors;
        }

        return $this->_colorScheme;
    }

    public function getColorMap(): array
    {
        $clrMap = $this->_element->clrMap;
        return [
            'bg1' => $clrMap->bg1,
            'tx1' => $clrMap->tx1,
            'bg2' => $clrMap->bg2,
            'tx2' => $clrMap->tx2,
            'accent1' => $clrMap->accent1,
            'accent2' => $clrMap->accent2,
            'accent3' => $clrMap->accent3,
            'accent4' => $clrMap->accent4,
            'accent5' => $clrMap->accent5,
            'accent6' => $clrMap->accent6,
            'hlink' => $clrMap->hlink,
            'folHlink' => $clrMap->folHlink,
        ];
    }

    public function getSchemeColor(string $scheme): string
    {
        $map = $this->getColorMap();
        $alias = $map[$scheme];
        return $this->getColorScheme()[$alias];
    }
}