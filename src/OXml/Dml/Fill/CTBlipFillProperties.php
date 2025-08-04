<?php

namespace Imoing\Pptx\OXml\Dml\Fill;

use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;

/**
 * @method CTRelativeRect _add_srcRect()
 * @method CTRelativeRect get_or_add_srcRect()
 * @property ?CTBlip $blip
 * @property ?CTRelativeRect $srcRect
 */
class CTBlipFillProperties extends AbsFill
{
    #[ZeroOrOne("a:blip", successors: ["a:srcRect", "a:tile", "a:stretch"])]
    protected ?CTBlip $_blip;

    #[ZeroOrOne("a:srcRect", successors: ["a:tile", "a:stretch"])]
    protected string $_srcRect;

    public function crop(array $cropping): void
    {
        $srcRect = $this->_add_srcRect();
        list($srcRect->l, $srcRect->t, $srcRect->r, $srcRect->b) = $cropping;
    }
}