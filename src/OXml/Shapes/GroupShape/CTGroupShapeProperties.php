<?php

namespace Imoing\Pptx\OXml\Shapes\GroupShape;

use Imoing\Pptx\OXml\Shapes\Shared\CTTransform2D;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;

/**
 * tag sequences: "a:xfrm","a:noFill","a:solidFill","a:gradFill","a:blipFill","a:pattFill","a:grpFill","a:effectLst",
 *                "a:effectDag","a:scene3d","a:extLst",
 * @method CTTransform2D get_or_add_xfrm()
 * @property ?CTTransform2D $xfrm
 */
class CTGroupShapeProperties extends BaseOXmlElement
{
    #[ZeroOrOne("a:xfrm", successors: [
        "a:noFill",
        "a:solidFill",
        "a:gradFill",
        "a:blipFill",
        "a:pattFill",
        "a:grpFill",
        "a:effectLst",
        "a:effectDag",
        "a:scene3d",
        "a:extLst",
    ])]
    protected ?CTTransform2D $xfrm;

    #[ZeroOrOne("a:effectLst", successors: ["a:effectDag", "a:scene3d", "a:extLst",])]
    protected mixed $effectLst;
}