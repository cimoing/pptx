<?php

namespace Imoing\Pptx\OXml\Shapes\Connector;

use Imoing\Pptx\OXml\Shapes\Shared\BaseShapeElement;
use Imoing\Pptx\OXml\SimpleTypes\STDrawingElementId;
use Imoing\Pptx\OXml\SimpleTypes\XsdUnsignedInt;
use Imoing\Pptx\OXml\XmlChemy\RequiredAttribute;

/**
 * @property int $idx
 */
class CTConnection extends BaseShapeElement
{
    #[RequiredAttribute("id", STDrawingElementId::class)]
    public string $id;

    #[RequiredAttribute("idx", XsdUnsignedInt::class)]
    protected int $idx;
}