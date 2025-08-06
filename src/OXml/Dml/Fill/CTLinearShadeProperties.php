<?php

namespace Imoing\Pptx\OXml\Dml\Fill;

use Imoing\Pptx\OXml\SimpleTypes\STPositiveFixedAngle;
use Imoing\Pptx\OXml\XmlChemy\BaseChildElement;
use Imoing\Pptx\OXml\XmlChemy\OptionalAttribute;

/**
 * @property float $ang
 */
class CTLinearShadeProperties extends AbsFill
{
    #[OptionalAttribute("ang", STPositiveFixedAngle::class)]
    protected string $_ang;
}