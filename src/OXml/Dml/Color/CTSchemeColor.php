<?php

namespace Imoing\Pptx\OXml\Dml\Color;

use Imoing\Pptx\Enum\MsoThemeColorIndex;
use Imoing\Pptx\OXml\XmlChemy\RequiredAttribute;

/**
 * @property MsoThemeColorIndex $val
 */
class CTSchemeColor extends BaseColorElement
{
    #[RequiredAttribute("val", MsoThemeColorIndex::class)]
    protected mixed $_val;

    public function isPlaceholderColor(): bool
    {
        return $this->val === MsoThemeColorIndex::PH_CLR;
    }
}