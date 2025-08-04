<?php

namespace Imoing\Pptx\OXml\Shapes\AutoShape;

use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;

/**
 * @property ?CTPath2DList $pathLst
 * @method CTPath2DList get_or_add_pathLst()
 */
class CTCustomGeometry2D extends BaseOXmlElement
{
    private static array $tagSequences = ["a:avLst", "a:gdLst", "a:ahLst", "a:cxnLst", "a:rect", "a:pathLst"];

    #[ZeroOrOne("a:pathLst", successors: [])]
    protected ?CTPath2DList $pathLst;
}