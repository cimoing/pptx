<?php

namespace Imoing\Pptx\OXml\Shapes\Shared;

use Imoing\Pptx\OXml\SimpleTypes\STAngle;
use Imoing\Pptx\OXml\SimpleTypes\XsdBoolean;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\OptionalAttribute;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;
use Imoing\Pptx\Util\Emu;
use Imoing\Pptx\Util\Length;

/**
 * tag sequences: "a:off","a:ext","a:chOff","a:chExt",
 * @method CTPoint2D get_or_add_off()
 * @method CTPositiveSize2D get_or_add_ext()
 * @method CTPositiveSize2D get_or_add_chExt()
 * @method CTPoint2D get_or_add_chOff()
 * @property ?float $rot
 * @property ?CTPoint2D $off
 * @property ?CTPoint2D $chOff
 * @property ?CTPositiveSize2D $ext
 * @property ?CTPositiveSize2D $chExt
 * @property bool $flipH
 * @property bool $flipV
 * @property ?Length $x
 * @property ?Length $y
 * @property ?Length $cx
 * @property ?Length $cy
 */
class CTTransform2D extends BaseOXmlElement
{
    #[ZeroOrOne("a:off", successors: ["a:ext","a:chOff","a:chExt",])]
    protected ?CTPoint2D $_off;

    #[ZeroOrOne("a:ext", successors: ["a:chOff","a:chExt",])]
    protected ?CTPositiveSize2D $_ext;

    #[ZeroOrOne("a:chOff", successors: ["a:chOff","a:chExt",])]
    protected ?CTPoint2D $_chOff;

    #[ZeroOrOne("a:chExt", successors: [])]
    protected ?CTPositiveSize2D $_chExt;

    #[OptionalAttribute("rot", STAngle::class, default: 0.0)]
    protected ?float $_rot;

    #[OptionalAttribute("flipH", XsdBoolean::class, default: false)]
    protected bool $_flipH;

    #[OptionalAttribute("flipV", XsdBoolean::class, default: false)]
    protected bool $_flipV;

    public function getX(): ?Length
    {
        /**
         * @var CTPoint2D $off
         */
        $off = $this->off;
        if (empty($off)) {
            return null;
        }

        return $off->x;
    }

    public function setX(?Length $x): void
    {
        $off = $this->get_or_add_off();
        $off->x = $x;
    }

    public function getY(): ?Length
    {
        /**
         * @var CTPoint2D $off
         */
        $off = $this->__get('off');
        if (empty($off)) {
            return null;
        }

        return $off->y;
    }

    public function setY(?Length $y): void
    {
        $off = $this->get_or_add_off();
        $off->y = $y;
    }

    public function getCx(): ?Length
    {
        /**
         * @var CTPositiveSize2D $ext
         */
        $ext = $this->__get('ext');
        if (empty($ext)) {
            return null;
        }

        return $ext->cx;
    }

    public function setCx(?Length $x): void
    {
        $ext = $this->get_or_add_ext();
        $ext->cy = $x;
    }

    public function getCy(): ?Length
    {
        /**
         * @var CTPositiveSize2D $ext
         */
        $ext = $this->__get('ext');
        if (empty($ext)) {
            return null;
        }

        return $ext->cy;
    }

    public function setCy(?Length $y): void
    {
        $ext = $this->get_or_add_ext();
        $ext->cy = $y;
    }

    protected function _new_ext(): CTPositiveSize2D
    {
        $ext = makeOXmlElement($this->ownerDocument, sprintf("<a:ext %s></a:ext>", nsdecls(["a"])));
        assert($ext instanceof CTPositiveSize2D);
        $ext->cx = new Emu(0);
        $ext->cy = new Emu(0);

        return $ext;
    }
}