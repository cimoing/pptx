<?php

namespace Imoing\Pptx\OXml\Shapes\Connector;

use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\OneAndOnlyOne;

/**
 * @property mixed $cNvPr
 * @property mixed $cNvCxnSpPr
 * @property mixed $nvPr
 */
class CTConnectorNonVisual extends BaseOXmlElement
{
    #[OneAndOnlyOne("p:cNvPr")]
    protected mixed $cNvPr;

    #[OneAndOnlyOne("p:cNvCxnSpPr")]
    protected mixed $cNvCxnSpPr;

    #[OneAndOnlyOne("p:nvPr")]
    protected mixed $nvPr;
}