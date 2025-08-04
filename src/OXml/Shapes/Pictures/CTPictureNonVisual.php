<?php

namespace Imoing\Pptx\OXml\Shapes\Pictures;

use Imoing\Pptx\OXml\Shapes\Shared\CTApplicationNonVisualDrawingProps;
use Imoing\Pptx\OXml\Shapes\Shared\CTNonVisualDrawingProps;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\OneAndOnlyOne;

/**
 * @property CTNonVisualDrawingProps $cNvPr
 * @property CTApplicationNonVisualDrawingProps $nvPr
 */
class CTPictureNonVisual extends BaseOXmlElement
{
    #[OneAndOnlyOne("p:cNvPr")]
    protected mixed $_cNvPr;

    #[OneAndOnlyOne("p:nvPr")]
    protected mixed $nvPr;
}