<?php

namespace Imoing\Pptx\OXml\Shapes\GroupShape;

use Imoing\Pptx\OXml\Dml\Fill\AbsFill;
use Imoing\Pptx\OXml\Shapes\Shared\CTTransform2D;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\Choice;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOneChoice;

/**
 * tag sequences: "a:xfrm","a:noFill","a:solidFill","a:gradFill","a:blipFill","a:pattFill","a:grpFill","a:effectLst",
 *                "a:effectDag","a:scene3d","a:extLst",
 * @method CTTransform2D get_or_add_xfrm()
 * @property ?CTTransform2D $xfrm
 * @property ?AbsFill $eg_fillProperties
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

    #[ZeroOrOneChoice([
        new Choice("a:noFill"),
        new Choice("a:solidFill"),
        new Choice("a:gradFill"),
        new Choice("a:blipFill"),
        new Choice("a:pattFill"),
        new Choice("a:grpFill"),
    ], successors: ["a:effectLst", "a:effectDag", "a:extLst",])]
    protected mixed $_eg_fillProperties;
}