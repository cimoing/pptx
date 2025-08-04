<?php

namespace Imoing\Pptx\OXml\Shapes\GroupShape;

use Imoing\Pptx\OXml\Shapes\Shared\BaseShapeElement;
use Imoing\Pptx\OXml\XmlChemy\OneAndOnlyOne;

class CTGroupShapeNonVisual extends BaseShapeElement
{
    #[OneAndOnlyOne("p:cNvPr")]
    protected mixed $cNvPr;
}