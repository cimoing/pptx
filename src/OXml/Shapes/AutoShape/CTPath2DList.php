<?php

namespace Imoing\Pptx\OXml\Shapes\AutoShape;

use Imoing\Pptx\OXml\SimpleTypes\STPositiveCoordinate;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\OptionalAttribute;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrMore;
use Imoing\Pptx\Util\Length;

/**
 * @method CTPath2D _add_path()
 * @property-read CTPath2D[] $path_lst
 */
class CTPath2DList extends BaseOXmlElement
{
    #[ZeroOrMore("a:path", successors: [])]
    protected array $_path;

    #[OptionalAttribute("w", STPositiveCoordinate::class)]
    protected ?Length $_w;

    #[OptionalAttribute("h", STPositiveCoordinate::class)]
    protected ?Length $_h;

    public function add_path(Length $width, Length $height): CTPath2D
    {
        $path = $this->_add_path();
        $path->height = $height;
        $path->width = $width;

        return $path;
    }
}