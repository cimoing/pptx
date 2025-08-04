<?php

namespace Imoing\Pptx\OXml\Shapes\AutoShape;

use Imoing\Pptx\OXml\SimpleTypes\XsdBoolean;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\OptionalAttribute;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;

/**
 * @property ?bool $txBox
 * @property string $spLocks
 */
class CTNonVisualDrawingShapeProps extends BaseOXmlElement
{
    #[ZeroOrOne("a:spLocks")]
    protected string $_spLocks;

    #[OptionalAttribute("txBox", XsdBoolean::class)]
    protected ?bool $_txBox;
}