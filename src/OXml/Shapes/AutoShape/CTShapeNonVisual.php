<?php

namespace Imoing\Pptx\OXml\Shapes\AutoShape;

use Imoing\Pptx\OXml\Shapes\Shared\CTApplicationNonVisualDrawingProps;
use Imoing\Pptx\OXml\Shapes\Shared\CTNonVisualDrawingProps;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\OneAndOnlyOne;


/**
 * @property CTNonVisualDrawingProps $cNvPr
 * @property CTNonVisualDrawingShapeProps $cNvSpPr
 * @property CTApplicationNonVisualDrawingProps $nvPr
 */
class CTShapeNonVisual extends BaseOXmlElement
{
    #[OneAndOnlyOne("p:cNvPr")]
    protected CTNonVisualDrawingProps $cNvPr;

    #[OneAndOnlyOne("p:cNvSpPr")]
    protected CTNonVisualDrawingShapeProps $cNvSpPr;

    #[OneAndOnlyOne("p:nvPr")]
    protected CTApplicationNonVisualDrawingProps $nvPr;
}