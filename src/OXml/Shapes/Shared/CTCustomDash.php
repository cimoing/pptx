<?php

namespace Imoing\Pptx\OXml\Shapes\Shared;

use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrMore;

/**
 * @property CTDashSegment[] $ds_lst
 */
class CTCustomDash extends BaseOXmlElement
{
    #[ZeroOrMore("a:ds")]
    protected array $_ds;
}