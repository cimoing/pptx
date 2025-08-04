<?php

namespace Imoing\Pptx\OXml\Shapes\AutoShape;

use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrMore;
use Imoing\Pptx\Util\Length;

/**
 * @method CTPath2D _add_path()
 */
class CTPath2DList extends BaseOXmlElement
{
    #[ZeroOrMore("a:path", successors: [])]
    protected array $path;

    public function add_path(Length $width, Length $height): CTPath2D
    {
        $path = $this->_add_path();
        $path->height = $height;
        $path->width = $width;

        return $path;
    }
}