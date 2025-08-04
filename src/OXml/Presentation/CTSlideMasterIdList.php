<?php

namespace Imoing\Pptx\OXml\Presentation;

use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrMore;

/**
 * @property-read CTSlideMasterIdListEntry[] $sldMasterId_lst
 */
class CTSlideMasterIdList extends BaseOXmlElement
{
    #[ZeroOrMore("p:sldMasterId")]
    protected array $sldMasterId;
}