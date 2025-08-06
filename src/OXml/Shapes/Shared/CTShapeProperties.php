<?php

namespace Imoing\Pptx\OXml\Shapes\Shared;

use Imoing\Pptx\OXml\Dml\Fill\AbsFill;
use Imoing\Pptx\OXml\Shapes\AutoShape\CTCustomGeometry2D;
use Imoing\Pptx\OXml\Shapes\AutoShape\CTPresetGeometry2D;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\Choice;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOneChoice;

/**
 * @method CTTransform2D get_or_add_xfrm()
 * @method CTLineProperties get_or_add_ln()
 * @method CTPresetGeometry2D _add_prstGeom()
 * @method void _remove_custGeom()
 * @property CTTransform2D $xfrm
 * @property ?CTCustomGeometry2D $custGeom
 * @property ?CTLineProperties $ln
 * @property ?CTPresetGeometry2D $prstGeom
 * @property ?AbsFill $eg_fillProperties
 */
class CTShapeProperties extends BaseOXmlElement
{
    #[ZeroOrOne("a:xfrm", successors: [
        "a:custGeom",
        "a:prstGeom",
        "a:noFill",
        "a:solidFill",
        "a:gradFill",
        "a:blipFill",
        "a:pattFill",
        "a:grpFill",
        "a:ln",
        "a:effectLst",
        "a:effectDag",
        "a:scene3d",
        "a:sp3d",
        "a:extLst",
    ])]
    protected ?CTTransform2D $_xfrm;

    #[ZeroOrOne("a:custGeom", successors: [
        "a:prstGeom",
        "a:noFill",
        "a:solidFill",
        "a:gradFill",
        "a:blipFill",
        "a:pattFill",
        "a:grpFill",
        "a:ln",
        "a:effectLst",
        "a:effectDag",
        "a:scene3d",
        "a:sp3d",
        "a:extLst",
    ])]
    protected ?CTCustomGeometry2D $_custGeom;

    #[ZeroOrOne("a:prstGeom", successors: [
        "a:noFill",
        "a:solidFill",
        "a:gradFill",
        "a:blipFill",
        "a:pattFill",
        "a:grpFill",
        "a:ln",
        "a:effectLst",
        "a:effectDag",
        "a:scene3d",
        "a:sp3d",
        "a:extLst",
    ])]
    protected ?CTPresetGeometry2D $_prstGeom;

    #[ZeroOrOneChoice([
        new Choice("a:noFill"),
        new Choice("a:solidFill"),
        new Choice("a:gradFill"),
        new Choice("a:blipFill"),
        new Choice("a:pattFill"),
        new Choice("a:grpFill"),
    ], successors: [
        "a:ln",
        "a:effectLst",
        "a:effectDag",
        "a:scene3d",
        "a:sp3d",
        "a:extLst",
    ])]
    protected mixed $_eg_fillProperties;

    #[ZeroOrOne("a:ln", successors: [
        "a:effectLst",
        "a:effectDag",
        "a:scene3d",
        "a:sp3d",
        "a:extLst",
    ])]
    protected ?CTLineProperties $_ln;

    #[ZeroOrOne("a:effectLst", successors: [
        "a:effectDag",
        "a:scene3d",
        "a:sp3d",
        "a:extLst",
    ])]
    protected $_effectLst;
}