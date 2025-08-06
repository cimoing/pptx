<?php

namespace Imoing\Pptx\OXml\Theme;

use Imoing\Pptx\OXml\SimpleTypes\XsdString;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\OptionalAttribute;

/**
 * @property string $bg1
 * @property string $tx1
 * @property string $bg2
 * @property string $tx2
 * @property string $accent1
 * @property string $accent2
 * @property string $accent3
 * @property string $accent4
 * @property string $accent5
 * @property string $accent6
 * @property string $hlink
 * @property string $folHlink
 */
class CTColorMap extends BaseOXmlElement
{
    #[OptionalAttribute("bg1", XsdString::class)]
    protected string $_bg1;

    #[OptionalAttribute("tx1", XsdString::class)]
    protected string $_tx1;

    #[OptionalAttribute("bg2", XsdString::class)]
    protected string $_bg2;

    #[OptionalAttribute("tx2", XsdString::class)]
    protected string $_tx2;

    #[OptionalAttribute("accent1", XsdString::class)]
    protected string $_accent1;
    #[OptionalAttribute("accent2", XsdString::class)]
    protected string $_accent2;

    #[OptionalAttribute("accent3", XsdString::class)]
    protected string $_accent3;

    #[OptionalAttribute("accent4", XsdString::class)]
    protected string $_accent4;

    #[OptionalAttribute("accent5", XsdString::class)]
    protected string $_accent5;

    #[OptionalAttribute("accent6", XsdString::class)]
    protected string $_accent6;

    #[OptionalAttribute("hlink", XsdString::class)]
    protected string $_hlink;

    #[OptionalAttribute("folHlink", XsdString::class)]
    protected string $_folHlink;
}