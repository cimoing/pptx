<?php

namespace Imoing\Pptx\OXml\Shapes\AutoShape;

use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrMore;

/**
 * @method CTGeomGuide _add_gd()
 * @property  CTGeomGuide[] gd_lst
 */
class CTGeomGuideList extends BaseOXmlElement
{
    #[ZeroOrMore("a:gd")]
    protected array $gd;
}