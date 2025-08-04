<?php

namespace Imoing\Pptx\OXml\Slide;

use Imoing\Pptx\OXml\XmlChemy\OneAndOnlyOne;

/**
 * tag sequences: "p:cSld", "p:clrMapOvr", "p:transition", "p:timing", "p:hf", "p:extLst"
 */
class CTSlideLayout extends BaseSlideElement
{
    #[OneAndOnlyOne("p:cSld")]
    protected CTCommonSlideData $_cSld;
}