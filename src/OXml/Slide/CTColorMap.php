<?php

namespace Imoing\Pptx\OXml\Slide;

use Imoing\Pptx\OXml\SimpleTypes\XsdString;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\OptionalAttribute;

class CTColorMap extends BaseOXmlElement
{
    #[OptionalAttribute("bg1", XsdString::class, default: "lt1")]
    protected string $_bg1;

    #[OptionalAttribute("tx1", XsdString::class, default: "dk1")]
    protected string $_tx1;

    #[OptionalAttribute("bg2", XsdString::class, default: "lt2")]
    protected string $_bg2;

    #[OptionalAttribute("tx2", XsdString::class, default: "dk2")]
    protected string $_tx2;

    #[OptionalAttribute("accent1", XsdString::class, default: "accent1")]
    protected string $_accent1;

    #[OptionalAttribute("accent2", XsdString::class, default: "accent2")]
    protected string $_accent2;

    #[OptionalAttribute("accent3", XsdString::class, default: "accent3")]
    protected string $_accent3;

    #[OptionalAttribute("accent4", XsdString::class, default: "accent4")]
    protected string $_accent4;

    #[OptionalAttribute("accent5", XsdString::class, default: "accent5")]
    protected string $_accent5;

    #[OptionalAttribute("accent6", XsdString::class, default: "accent6")]
    protected string $_accent6;

    #[OptionalAttribute("hlink", XsdString::class, default: "hlink")]
    protected string $_hlink;

    #[OptionalAttribute("folHlink", XsdString::class, default: "folHlink")]
    protected string $_folHlink;
}