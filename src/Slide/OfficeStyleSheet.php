<?php

namespace Imoing\Pptx\Slide;

use Imoing\Pptx\OXml\Theme\CTOfficeStyleSheet;
use Imoing\Pptx\Shared\PartElementProxy;

/**
 * @property-read CTOfficeStyleSheet $_element
 * @property string $name
 * @property array $colorSchemeHex
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
}