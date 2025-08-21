<?php

namespace Imoing\Pptx\OXml\Slide;

use Imoing\Pptx\OXml\Theme\CTColorMapOverrides;
use Imoing\Pptx\OXml\XmlChemy\OneAndOnlyOne;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;

/**
 * tag sequences: "p:cSld", "p:clrMapOvr", "p:transition", "p:timing", "p:hf", "p:extLst"
 * @property ?CTColorMapOverrides $clrMapOvr
 */
class CTSlideLayout extends BaseSlideElement
{
    #[OneAndOnlyOne("p:cSld")]
    protected CTCommonSlideData $_cSld;

    #[ZeroOrOne("p:clrMapOvr", successors: ["p:transition", "p:timing", "p:extLst"])]
    protected ?CTColorMapOverrides $_clrMapOvr;
}