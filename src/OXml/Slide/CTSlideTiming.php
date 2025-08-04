<?php

namespace Imoing\Pptx\OXml\Slide;

use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;

class CTSlideTiming extends BaseOXmlElement
{
    #[ZeroOrOne("p:tnLst", successors: ["p:bldLst", "p:extLst"])]
    protected mixed $tnLst;
}