<?php

namespace Imoing\Pptx\OXml\Theme;

use Imoing\Pptx\Dml\Color\ColorFormat;
use Imoing\Pptx\OXml\Dml\Color\CTColor;
use Imoing\Pptx\OXml\SimpleTypes\XsdString;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\OneAndOnlyOne;
use Imoing\Pptx\OXml\XmlChemy\RequiredAttribute;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;

/**
 * @property string $name
 * @property CTColor $dk1
 * @property CTColor $lt1
 * @property CTColor $dk2
 * @property CTColor $lt2
 * @property CTColor $accent1
 * @property CTColor $accent2
 * @property CTColor $accent3
 * @property CTColor $accent4
 * @property CTColor $accent5
 * @property CTColor $accent6
 * @property CTColor $hlink
 * @property CTColor $folHlink
 * @property CTColor $tx1
 * @property CTColor $tx2
 * @property CTColor $bg1
 * @property CTColor $bg2
 */
class CTColorScheme extends BaseOXmlElement
{
    #[RequiredAttribute("name", XsdString::class)]
    protected string $_name;

    #[ZeroOrOne("a:dk1")]
    protected mixed $_dk1;

    #[ZeroOrOne("a:lt1")]
    protected mixed $_lt1;

    #[ZeroOrOne("a:dk2")]
    protected mixed $_dk2;

    #[ZeroOrOne("a:lt2")]
    protected mixed $_lt2;

    #[ZeroOrOne("a:accent1")]
    protected mixed $_accent1;

    #[ZeroOrOne("a:accent2")]
    protected mixed $_accent2;

    #[ZeroOrOne("a:accent3")]
    protected mixed $_accent3;

    #[ZeroOrOne("a:accent4")]
    protected mixed $_accent4;

    #[ZeroOrOne("a:accent5")]
    protected mixed $_accent5;

    #[ZeroOrOne("a:accent6")]
    protected mixed $_accent6;

    #[ZeroOrOne("a:hlink")]
    protected mixed $_hlink;

    #[ZeroOrOne("a:folHlink")]
    protected mixed $_folHlink;

    #[ZeroOrOne("a:tx1")]
    protected mixed $_tx1;

    #[ZeroOrOne("a:tx2")]
    protected mixed $_tx2;

    #[ZeroOrOne("a:bg1")]
    protected mixed $_bg1;

    #[ZeroOrOne("a:bg2")]
    protected mixed $_bg2;

    public function toHexArray(): array
    {
        $names = ['dk1', 'lt1', 'dk2', 'lt2', 'accent1', 'accent2', 'accent3', 'accent4', 'accent5', 'accent6', 'hlink', 'folHlink'];
        $colors = [];

        foreach ($names as $name) {
            $color = ColorFormat::fromColorChoiceParent($this->{$name});
            $colors[$name] = (string) $color->getRgb();
        }

        return $colors;
    }
}