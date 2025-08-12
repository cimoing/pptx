<?php

namespace Imoing\Pptx\OXml\Shapes\AutoShape;

use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;

/**
 * @property CTAdjPoint2D $pt
 * @method CTAdjPoint2D _add_pt()
 */
class CTPath2DMoveTo extends BaseOXmlElement
{
    #[ZeroOrOne("a:pt", successors: [])]
    protected mixed $_pt;

    public function getCommand(): string
    {
        return 'M';
    }

    public function getPtLst(): array
    {
        $pt = $this->pt;
        return !empty($pt) ? [$pt] : [];
    }

    public function getPointArray(): array
    {
        return [
            'x' => $this->pt->x->px,
            'y' => $this->pt->y->px,
            'relative' => true,
            'type' => $this->getCommand(),
        ];
    }
}