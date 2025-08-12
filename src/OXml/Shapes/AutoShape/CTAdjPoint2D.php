<?php

namespace Imoing\Pptx\OXml\Shapes\AutoShape;

use Imoing\Pptx\OXml\SimpleTypes\STCoordinate;
use Imoing\Pptx\OXml\SimpleTypes\XsdString;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\RequiredAttribute;
use Imoing\Pptx\Util\Length;

/**
 * @property Length $x
 * @property string $fX
 * @property Length $y
 * @property string $fY
 */
class CTAdjPoint2D extends BaseOXmlElement
{
    #[RequiredAttribute("x", STCoordinate::class)]
    protected Length $_x;

    #[RequiredAttribute("x", XsdString::class)]
    protected ?string $_fX;

    #[RequiredAttribute("y", STCoordinate::class)]
    protected Length $_y;

    #[RequiredAttribute("y", XsdString::class)]
    protected ?string $_fY;
}