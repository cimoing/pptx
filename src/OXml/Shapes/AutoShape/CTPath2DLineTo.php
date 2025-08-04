<?php

namespace Imoing\Pptx\OXml\Shapes\AutoShape;

use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;

/**
 * @property ?CTAdjPoint2D $pt
 * @method CTAdjPoint2D _add_pt()
 */
class CTPath2DLineTo extends BaseOXmlElement
{
    #[ZeroOrOne("a:pt", successors: [])]
    protected ?CTAdjPoint2D $pt;
}