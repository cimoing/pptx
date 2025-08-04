<?php

namespace Imoing\Pptx\OXml\Shapes\AutoShape;

use Imoing\Pptx\OXml\SimpleTypes\STPositiveCoordinate;
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
}