<?php

namespace Imoing\Pptx\OXml\Shapes\Shared;

use Imoing\Pptx\OXml\SimpleTypes\STCoordinate;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\RequiredAttribute;
use Imoing\Pptx\Util\Length;

/**
 * @property Length $x
 * @property Length $y
 */
class CTPoint2D extends BaseOXmlElement
{
    #[RequiredAttribute("x", STCoordinate::class)]
    protected Length $_x;

    #[RequiredAttribute("y", STCoordinate::class)]
    protected Length $_y;
}