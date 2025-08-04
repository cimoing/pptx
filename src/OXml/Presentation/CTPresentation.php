<?php

namespace Imoing\Pptx\OXml\Presentation;

use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrMore;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;

/**
 * @property ?CTSlideSize $sldSz
 * @property ?CTSlideMasterIdList $slideMasterIdList;
 * @property ?CTSlideIdList $sldIdLst;
 * @method CTSlideMasterIdList get_or_add_sldMasterIdLst()
 * @method CTSlideIdList get_or_add_sldIdLst()
 * @method CTSlideSize get_or_add_sldSz()
 */
class CTPresentation extends BaseOXmlElement
{
    #[ZeroOrOne("p:sldMasterIdLst", successors: [
        "p:notesMasterIdLst",
        "p:handoutMasterIdLst",
        "p:sldIdLst",
        "p:sldSz",
        "p:notesSz",
    ])]
    protected ?CTSlideMasterIdList $_sldMasterIdLst;

    #[ZeroOrOne("p:sldIdLst", successors: ["p:sldSz", "p:notesSz"])]
    protected ?CTSlideIdList $_sldIdLst;

    #[ZeroOrOne("p:sldSz", successors: ["p:notesSz"])]
    protected ?CTSlideSize $_sldSz;
}