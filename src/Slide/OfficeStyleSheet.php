<?php

namespace Imoing\Pptx\Slide;

use Imoing\Pptx\Dml\Fill\Fill;
use Imoing\Pptx\OXml\Theme\CTFonts;
use Imoing\Pptx\OXml\Theme\CTOfficeStyleSheet;
use Imoing\Pptx\Parts\Theme\OfficeStyleSheetPart;
use Imoing\Pptx\Shared\PartElementProxy;

/**
 * @property-read CTOfficeStyleSheet $_element
 * @property string $name
 * @property array $colorSchemeHex
 * @property-read OfficeStyleSheetPart $part
 */
class OfficeStyleSheet extends PartElementProxy
{
    public function getName(): string
    {
        return $this->_element->name;
    }

    public function setName(?string $name): void
    {
        $newName = empty($name) ? "" : $name;
        $this->_element->name = $newName;
    }

    private ?array $_schemeColors = null;

    public function getColorSchemeHex(): array
    {
        if ($this->_schemeColors === null) {
            $this->_schemeColors = $this->_element->themeElements->clrScheme->getColors();
        }
        return $this->_schemeColors;
    }
    public function getScheme(string $name)
    {
        return $this->colorSchemeHex[$name] ?? null;
    }

    public function getMajorFont(): CTFonts
    {
        return $this->_element->themeElements->fontScheme->majorFont;
    }

    public function getMinorFont(): CTFonts
    {
        return $this->_element->themeElements->fontScheme->minorFont;
    }

    public function offsetGetFill(int $idx): ?Fill
    {
        if ($idx <= 1000) {
            $base = 1;
            $children = $this->_element->themeElements->fmtScheme->fillStyleLst->getChildren();
        } else {
            $base = 1001;
            $children = $this->_element->themeElements->fmtScheme->bgFillStyleLst->getChildren();
        }
        foreach ($children as $k => $child) {
            $id = $k + $base;
            if ($id === $idx) {
                return Fill::create($child);
            }
        }

        return null;
    }
}