<?php

namespace Imoing\Pptx\OXml\Slide;

use Imoing\Pptx\OXml\Shapes\GroupShape\CTGroupShape;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;

/**
 * @property CTCommonSlideData $cSld
 * @property-read CTGroupShape $spTree
 */
abstract class BaseSlideElement extends BaseOXmlElement
{
    protected function getSpTree(): \Imoing\Pptx\OXml\Shapes\GroupShape\CTGroupShape
    {
        return $this->cSld->spTree;
    }
}