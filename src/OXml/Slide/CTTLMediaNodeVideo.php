<?php

namespace Imoing\Pptx\OXml\Slide;

use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\OneAndOnlyOne;

/**
 * @property mixed $cMediaNode
 */
class CTTLMediaNodeVideo extends BaseOXmlElement
{
    #[OneAndOnlyOne("p:cMediaNode")]
    protected mixed $cMediaNode;
}