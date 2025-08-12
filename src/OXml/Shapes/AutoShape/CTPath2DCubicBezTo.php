<?php

namespace Imoing\Pptx\OXml\Shapes\AutoShape;

use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrMore;

/**
 * @property-read CTAdjPoint2D[] $pt_lst
 */
class CTPath2DCubicBezTo extends BaseOXmlElement
{
    #[ZeroOrMore("a:pt", successors: [])]
    protected array $_pt;

    public function getCommand(): string
    {
        return 'C';
    }

    public function getPtLst(): array
    {
        return !empty($this->pt_lst) ? $this->pt_lst : [];
    }

    public function getPointArray(): array
    {
        $items = $this->getPtLst();
        return [
            'type' => $this->getCommand(),
            'relative' => true,
            'x' => $items[0]->x->px,
            'y' => $items[0]->y->px,
            'curve' => [
                'type' => 'cubic',
                'x1' => $items[1]->x->px,
                'y1' => $items[1]->y->px,
                'x2' => $items[2]->x->px,
                'y2' => $items[2]->y->px,
            ],
        ];
    }
}