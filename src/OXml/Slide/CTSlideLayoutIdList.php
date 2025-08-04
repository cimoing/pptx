<?php

namespace Imoing\Pptx\OXml\Slide;

use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrMore;

/**
 * @property CTSlideLayoutIdListEntry[] $sldLayoutId_lst
 */
class CTSlideLayoutIdList extends BaseOXmlElement
{
    #[ZeroOrMore("p:sldLayoutId")]
    protected mixed $sldLayoutId;
}