<?php

namespace Imoing\Pptx\OXml\Slide;

use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\OneAndOnlyOne;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;

/**
 * @method CTSlideLayoutIdList get_or_add_sldLayoutIdLst()
 */
class CTSlideMaster extends BaseOXmlElement
{
    #[OneAndOnlyOne("p:cSld")]
    protected CTCommonSlideData $_cSld;

    #[ZeroOrOne("p:sldLayoutIdLst", successors: ["p:transition", "p:timing", "p:hf", "p:txStyles", "p:extLst",])]
    protected CTSlideLayoutIdList $_sldLayoutIdLst;
}