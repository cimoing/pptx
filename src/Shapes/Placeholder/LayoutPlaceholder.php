<?php

namespace Imoing\Pptx\Shapes\Placeholder;

use Imoing\Pptx\Enum\MsoVerticalAnchor;
use Imoing\Pptx\Enum\PPPlaceholderType;
use Imoing\Pptx\OXml\Dml\Fill\CTLevelParaProperties;
use Imoing\Pptx\OXml\Drawing\CTListStyle;
use Imoing\Pptx\OXml\Shapes\AutoShape\CTShape;
use Imoing\Pptx\Parts\Slide\SlideLayoutPart;
use Imoing\Pptx\Shapes\AutoShape\Shape;
use Imoing\Pptx\Shapes\Base\TextLevelParaStyle;
use Imoing\Pptx\Shapes\Base\TextLevelParaStyleLst;

/**
 * @property CTShape $_element
 * @property-read SlideLayoutPart $part
 */
class LayoutPlaceholder extends Shape
{
    use InheritsDimensions;


    protected function getBasePlaceholder(): ?MasterPlaceholder
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

    private ?TextLevelParaStyleLst $_textLevelParaStyleLst = null;
    public function getTextLevelParaStyleLst(): TextLevelParaStyleLst
    {
        if (is_null($this->_textLevelParaStyleLst)) {
            $parent = $this->getBasePlaceholder()->getTextLevelParaStyleLst();

            $lstStyle = $this->_element->txBody?->lstStyle;
            $this->_textLevelParaStyleLst = $lstStyle ? $parent->withChild($lstStyle, $this->theme) : new TextLevelParaStyleLst($lstStyle, $this->theme);
        }

        return $this->_textLevelParaStyleLst;
    }

    public function getTextVAlign(): ?MsoVerticalAnchor
    {
        $anchor = parent::getTextVAlign();
        if (!$anchor) {
            $anchor = $this->getBasePlaceholder()->getTextVAlign();
        }

        return $anchor;
    }
}