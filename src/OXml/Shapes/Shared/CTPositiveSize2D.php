<?php

namespace Imoing\Pptx\OXml\Shapes\Shared;

use Imoing\Pptx\OXml\SimpleTypes\STPositiveCoordinate;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\RequiredAttribute;
use Imoing\Pptx\Util\Length;

/**
 * @property Length $cx
 * @property Length $cy
 */
class CTPositiveSize2D extends BaseOXmlElement
{
    #[RequiredAttribute("cx", STPositiveCoordinate::class)]
    protected Length $cx;

    #[RequiredAttribute("cy", STPositiveCoordinate::class)]
    protected Length $cy;
}