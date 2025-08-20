<?php

namespace Imoing\Pptx\Shapes;

use Imoing\Pptx\Common\Point;
use Imoing\Pptx\Dml\Fill\FillFormat;
use Imoing\Pptx\Enum\MsoShapeType;
use Imoing\Pptx\OXml\Shapes\GroupShape\CTGroupShape;
use Imoing\Pptx\Shapes\Base\BaseShape;
use Imoing\Pptx\Shapes\ShapeTree\ShapeTree;
use Imoing\Pptx\Types\ProvidesPart;
use Imoing\Pptx\Util\Emu;
use Imoing\Pptx\Util\Length;

/**
 * @property Length[] $childOff
 */
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

    public function getChildOff(): array
    {
        return [
            $this->_sp->grpSpPr->xfrm->chOff?->x ?: $this->left,
            $this->_sp->grpSpPr->xfrm->chOff?->y ?: $this->top,
        ];
    }

    public function getChildSize(): array
    {
        return [
            $this->_sp->grpSpPr->xfrm->chExt?->cx ?: $this->width,
            $this->_sp->grpSpPr->xfrm->chExt?->cy ?: $this->height,
        ];
    }

    /**
     * 相对中心点 子节点均按照此点进行旋转并执行偏移，未偏移的中心点
     * @return Point
     */
    public function getCenterPoint(): Point
    {
        $relative = new Point(
            $this->width->emu,
            $this->height->emu
        );

        return (new Point(0,0))->getCenter($relative);
    }

    public function getAbsPoint(Point $relativePoint): Point
    {
        $center = $this->getCenterPoint(); // 中心点
        $chOff = $this->getChildOff(); // 子节点相对偏移量
        $chExt = $this->getChildSize();
        $offset = $this->getOffsetPoint();

        $scaleX = $chExt[0]->emu / $this->width->emu;
        $scaleY = $chExt[1]->emu / $this->height->emu;

        $relativePoint = new Point(intval(($relativePoint->x - $chOff[0]->emu) * $scaleX), intval(($relativePoint->y - $chOff[1]->emu) * $scaleY)); // 子节点左顶点在当前节点位置

        if ($this->flipV) {
            $relativePoint->flipV($center);
        }
        if ($this->flipH) {
            $relativePoint->flipH($center);
        }

        $relativePoint = $relativePoint->rotate($this->rotation, $center); // 获取子节点在当前节点旋转后的位置

        $relativePoint->move($offset); // 平移并返回
        return $this->_parent->getAbsPoint($relativePoint);
    }

    public function getSizePoint(): Point
    {
        return new Point(
            $this->width->emu,
            $this->height->emu
        );
    }

    public function getChExt(): ?array
    {
        return [$this->_sp->grpSpPr->xfrm->chExt?->cx, $this->_sp->grpSpPr->xfrm->chExt?->cy];
    }

    public function toArray(): array
    {
        $arr = parent::toArray();

        $elements = [];
        foreach ($this as $elm) {
            $elements[] = $elm->toArray();
        }
        return array_merge($arr, [
            'elements' => $elements,
        ]);
    }
}