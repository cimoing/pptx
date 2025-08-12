<?php

namespace Imoing\Pptx\Shapes;

use Imoing\Pptx\Dml\Fill\FillFormat;
use Imoing\Pptx\Enum\MsoShapeType;
use Imoing\Pptx\OXml\Shapes\GroupShape\CTGroupShape;
use Imoing\Pptx\Shapes\Base\BaseShape;
use Imoing\Pptx\Shapes\ShapeTree\ShapeTree;
use Imoing\Pptx\Types\ProvidesPart;

class GroupShape extends BaseShape implements \IteratorAggregate
{
    private CTGroupShape $_sp;
    public function __construct(CTGroupShape $shapeElement, ProvidesPart $part)
    {
        parent::__construct($shapeElement, $part);
        $this->_sp = $shapeElement;
    }
    public function getShapeType(): MsoShapeType
    {
        return MsoShapeType::GROUP;
    }

    private ?FillFormat $_fill = null;
    public function getFill(): FillFormat
    {
        if (is_null($this->_fill)) {
            $this->_fill = FillFormat::fromFillParent($this->_sp->grpSpPr);
        }

        return $this->_fill;
    }

    /**
     * @return \Traversable<int,BaseShape>
     */
    public function getIterator(): \Traversable
    {
        foreach ($this->_sp->iter_shape_elms() as $elm) {
            yield ShapeTree::baseShapeFactory($elm, $this);
        }
    }

    public function getSchemeColor(string $scheme): string
    {
        return $this->_parent->getSchemeColor($scheme);
    }

    public function getChOff(): ?array
    {
        return [$this->_sp->grpSpPr->xfrm->chOff?->x, $this->_sp->grpSpPr->xfrm->chOff?->y];
    }

    public function getChExt(): ?array
    {
        return [$this->_sp->grpSpPr->xfrm->chExt?->cx, $this->_sp->grpSpPr->xfrm->chExt?->cy];
    }

    public function toArray(): array
    {
        $arr = parent::toArray();

        $chOff = $this->getChOff();
        $chOff = [$chOff[0]?->px ?: 0, $chOff[1]?->px ?: 0];
        $chExt = $this->getChExt();
        $chExt = [$chExt[0]?->px ?: 0, $chExt[1]?->px ?: 0];

        $ws = $arr['width'] / $chExt[0];
        $hs = $arr['height'] / $chExt[1];
        $elements = [];
        foreach ($this as $elm) {
            $element = $elm->toArray();
            $element['left'] = ($element['left'] -  $chOff[0]) * $ws;
            $element['top'] = ($element['top'] -  $chOff[1]) * $hs;
            $element['width'] = $element['width'] * $ws;
            $element['height'] = $element['height'] * $hs;

            $elements[] = $element;
        }
        return array_merge(parent::toArray(), [
            'elements' => $elements,
        ]);
    }
}