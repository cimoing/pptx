<?php

namespace Imoing\Pptx\OXml\Drawing;

use Imoing\Pptx\OXml\SimpleTypes\STPositiveCoordinate;
use Imoing\Pptx\OXml\SimpleTypes\STPositiveFixedAngle;
use Imoing\Pptx\OXml\XmlChemy\Choice;
use Imoing\Pptx\OXml\XmlChemy\OptionalAttribute;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOneChoice;
use Imoing\Pptx\Util\Length;

/**
 * @property ?string $dir
 * @property ?Length $dist
 * @property ?Length $blurRad
 */
class CTOuterShadow extends AbsEffect
{
    #[ZeroOrOneChoice([
        new Choice("a:hslClr"),
        new Choice("a:prstClr"),
        new Choice("a:schemeClr"),
        new Choice("a:scrgbClr"),
        new Choice("a:srgbClr"),
        new Choice("a:sysClr"),
    ], successors: [])]
    protected mixed $eg_colorChoice;

    #[OptionalAttribute("dir", STPositiveFixedAngle::class)]
    protected ?string $_dir;

    #[OptionalAttribute("dist", STPositiveCoordinate::class)]
    protected ?string $_dist;

    #[OptionalAttribute("blurRad", STPositiveCoordinate::class)]
    protected ?Length $_blurRad;
}