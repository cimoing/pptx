<?php

namespace Imoing\Pptx\Shapes\Placeholder;

use Imoing\Pptx\Enum\PPPlaceholderType;
use Imoing\Pptx\OXml\Dml\Fill\CTLevelParaProperties;
use Imoing\Pptx\OXml\Drawing\CTListStyle;
use Imoing\Pptx\OXml\Shapes\AutoShape\CTShape;
use Imoing\Pptx\Shapes\AutoShape\Shape;

/**
 * @property CTShape $_element
 */
class LayoutPlaceholder extends Shape
{
    use InheritsDimensions;


    protected function getBasePlaceholder(): mixed
    {
        $baseType = match ($this->_element->phType) {
            PpPlaceholderType::BODY, PpPlaceholderType::CHART, PpPlaceholderType::BITMAP, PpPlaceholderType::ORG_CHART, PpPlaceholderType::MEDIA_CLIP, PpPlaceholderType::OBJECT, PpPlaceholderType::PICTURE, PpPlaceholderType::SUBTITLE, PpPlaceholderType::TABLE => PpPlaceholderType::BODY,
            PpPlaceholderType::CENTER_TITLE, PpPlaceholderType::TITLE => PpPlaceholderType::TITLE,
            PpPlaceholderType::DATE => PpPlaceholderType::DATE,
            PpPlaceholderType::FOOTER => PpPlaceholderType::FOOTER,
            PpPlaceholderType::SLIDE_NUMBER => PpPlaceholderType::SLIDE_NUMBER,
            default => $this->_element->phType,
        };

        $slideMaster = $this->part->slideMaster;

        return $slideMaster->placeholders->get($baseType, null);
    }

    public function getLstStyle(): ?CTListStyle
    {
        return $this->_element->txBody?->lstStyle;
    }

    public function getLevelPPr(int $level): ?CTLevelParaProperties
    {
        $style = $this->getLstStyle();
        $propName = 'lvl' . $level . 'pPr';
        return $style?->$propName;
    }
}