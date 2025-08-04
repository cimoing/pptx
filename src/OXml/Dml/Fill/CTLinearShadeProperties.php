<?php

namespace Imoing\Pptx\OXml\Dml\Fill;

use Imoing\Pptx\OXml\SimpleTypes\STPositiveFixedAngle;
use Imoing\Pptx\OXml\XmlChemy\BaseChildElement;
use Imoing\Pptx\OXml\XmlChemy\OptionalAttribute;

/**
 * @property string $ang
 */
class CTLinearShadeProperties extends BaseChildElement
{
    #[OptionalAttribute("ang", STPositiveFixedAngle::class)]
    protected string $_ang;
}