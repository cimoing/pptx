<?php

namespace Imoing\Pptx\Shapes\Placeholder;

use Imoing\Pptx\Enum\MsoVerticalAnchor;
use Imoing\Pptx\Shapes\Base\TextLevelParaStyleLst;
use Imoing\Pptx\Shapes\Base\Transform2D;

class SlidePlaceholder extends BaseSlidePlaceholder
{
    private ?Transform2D $_transform = null;
    public function getTransform2D(): Transform2D
    {
        if (is_null($this->_transform)) {
            $xfrm = $this->_element->getXfrm();
            if (!$xfrm) {
                $xfrm = $this->getBasePlaceholder()->element->getXfrm();
            }
            $this->_transform = new Transform2D($xfrm, $this->_parent->getTransform2D());
        }

        return $this->_transform;
    }

    private ?TextLevelParaStyleLst $_textLevelParaStyleLst = null;
    public function getTextLevelParaStyleLst(): TextLevelParaStyleLst
    {
        if (is_null($this->_textLevelParaStyleLst)) {
            $parent = $this->getBasePlaceholder()->getTextLevelParaStyleLst();
            if ($this->_element->txBody?->lstStyle) {
                $this->_textLevelParaStyleLst = $parent->withChild($this->_element->txBody->lstStyle, $this->theme);
            } else {
                $this->_textLevelParaStyleLst = $parent;
            }
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