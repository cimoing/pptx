<?php

namespace Imoing\Pptx\OXml\Drawing;

use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;

/**
 * @property ?CTOuterShadow $outerShdw
 */
class CTEffectList extends BaseOXmlElement
{
    #[ZeroOrOne("a:outerShdw")]
    protected ?CTOuterShadow $_outerShdw;
}