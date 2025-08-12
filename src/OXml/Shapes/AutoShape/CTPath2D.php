<?php

namespace Imoing\Pptx\OXml\Shapes\AutoShape;

use Imoing\Pptx\OXml\Ns\NsMap;
use Imoing\Pptx\OXml\SimpleTypes\STPositiveCoordinate;
use Imoing\Pptx\OXml\SimpleTypes\XsdString;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\OptionalAttribute;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrMore;
use Imoing\Pptx\Util\Length;

/**
 * @method CTPath2DClose _add_close()
 * @method CTPath2DLineTo _add_lnTo()
 * @method CTPath2DMoveTo _add_moveTo()
 * @property CTPath2DClose[] $closes
 * @property CTPath2DLineTo[] $lnTo;
 * @property CTPath2DMoveTo[] $moveTo
 * @property ?Length $width;
 * @property ?Length $height
 * @property ?string $path
 * @property CTPath2DClose[]|CTPath2DLineTo[]|CTPath2DMoveTo[]|CTPath2DCubicBezTo[] $contentChildren
 */
class CTPath2D extends BaseOXmlElement
{
    #[ZeroOrMore("a:close", successors: [])]
    protected array $_closes;

    #[ZeroOrMore("a:lnTo", successors: [])]
    protected array $_lnTo;

    #[ZeroOrMore("a:moveTo", successors: [])]
    protected array $_moveTo;

    #[OptionalAttribute("w", STPositiveCoordinate::class)]
    protected ?Length $_width;

    #[OptionalAttribute("h", STPositiveCoordinate::class)]
    protected ?Length $_height;

    #[OptionalAttribute("path", XsdString::class)]
    protected ?string $_path;

    public function add_close(): CTPath2DClose
    {
        return $this->_add_close();
    }

    public function add_lnTo(Length $x, Length $y): CTPath2DLineTo
    {
        $lnTo = $this->_add_lnTo();
        $pt = $lnTo->_add_pt();
        $pt->x = $x;
        $pt->y = $y;

        return $lnTo;
    }

    public function add_moveTo(Length $x, Length $y): CTPath2DMoveTo
    {
        $lnTo = $this->_add_moveTo();
        $pt = $lnTo->_add_pt();
        $pt->x = $x;
        $pt->y = $y;

        return $lnTo;
    }

    /**
     * @return BaseOXmlElement[]
     */
    public function getContentChildren(): array
    {
        $result = [];
        foreach ($this->childNodes as $node) {
            if ($node instanceof \DOMElement && in_array($node->tagName, ["a:close", "a:lnTo", "a:moveTo","a:cubicBezTo"])) {
                $result[] = NsMap::castDom($node);
            }
        }

        return $result;
    }
}