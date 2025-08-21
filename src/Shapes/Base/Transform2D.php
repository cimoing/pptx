<?php

namespace Imoing\Pptx\Shapes\Base;

use Imoing\Pptx\Common\BaseObject;
use Imoing\Pptx\Common\Point;
use Imoing\Pptx\OXml\Shapes\Shared\CTTransform2D;

/**
 * 2D图形变换
 * 用于计算2D图形的坐标
 * @property-read Point $offset 偏移 x:水平偏移 y:垂直偏移
 * @property-read Point $inheritOffset 继承的偏移 x:水平偏移 y:垂直偏移
 * @property-read Point $size 尺寸 x:宽 y:高
 * @property-read Point $absSize 绝对尺寸 x:宽 y:高
 * @property-read ?Point $childOffset 子节点偏移 x:水平偏移 y:垂直偏移
 * @property-read ?Point $childSize 子节点尺寸 x:宽 y:高
 * @property-read bool $flipV 垂直翻转
 * @property-read bool $flipH 水平翻转
 * @property-read Point $scale 当前形状下子节点缩放比例 x: 横向缩放 y: 纵向缩放
 * @property-read Point $absScale 当前形状下子节点整体缩放比例 x: 横向缩放 y: 纵向缩放
 * @property-read Point $inheritScale 继承的缩放比例 x: 横向缩放 y: 纵向缩放
 * @property-read float $rotation 旋转角度
 * @property-read float $absRotation 绝对旋转角度（包含自身）
 * @property-read float $inheritRotation 继承的旋转角度（不包含自身）
 */
class Transform2D extends BaseObject
{
    private ?Transform2D $_parent;
    private CTTransform2D $_transform2D;
    public function __construct(CTTransform2D $transform2D, ?Transform2D $parent = null)
    {
        parent::__construct([]);
        $this->_transform2D = $transform2D;
        $this->_parent = $parent;
    }

    /**
     * 计算当前点在整体坐标系中的坐标（不包含自身反转、旋转等）
     * 对于矩形来说无论如何变换，中心点的绝对位置是不变的，因此可以通过中心点坐标反向计算其它坐标
     * @param Point $point
     * @return Point
     */
    public function calInheritPoint(Point $point): Point
    {
        $point->move($this->getOffset());
        return $this->_parent ? $this->_parent->calChildAbsPoint($point) : $point;
    }

    /**
     * 计算子节点坐标当前绝对位置（含自身变换）
     * @param Point $point
     * @return Point
     */
    public function calChildAbsPoint(Point $point): Point
    {
        $center = $this->getSize()->getCenter();
        $chOff = $this->getChildOffset();
        $scale = $this->getScale();

        $point->move(new Point(-$chOff->x, -$chOff->y)) // 偏移
            ->scale($scale); // 缩放

        if ($this->getFlipV()) {
            $point->flipV($center); // 垂直翻转
        }

        if ($this->getFlipH()) {
            $point->flipH($center); // 水平翻转
        }

        $rot = $this->getRotation();
        $point->rotate($rot, $center);

        $point->move($this->getOffset()); // 平移

        if ($this->_parent) {
            $point = $this->_parent->calChildAbsPoint($point); // 经过父级变换
        }

        return $point;
    }

    /**
     * 获取当前形状内坐标（变换前）的绝对位置
     * @param Point $point
     * @return Point
     */
    public function calAbsPoint(Point $point): Point
    {
        $point = $this->calPoint($point);
        return $this->calInheritPoint($point);
    }

    public function calRelativeAbsPoint(Point $point): Point
    {
        $offset = $this->calAbsPoint(new Point(0,0))->scale(new Point(-1, -1));
        $point = $this->calAbsPoint($point);
        return $point->move($offset);
    }

    /**
     * 获取当前形状内变换后的坐标
     * @param Point $point
     * @return Point
     */
    public function calPoint(Point $point): Point
    {
        $rot = $this->getRotation();
        $center = $this->getSize()->getCenter();
        $point->rotate($rot, $center);
        if ($this->getFlipV()) {
            $point->flipV($center);
        }
        if ($this->getFlipH()) {
            $point->flipH($center);
        }
        return $point;
    }

    protected function getSize(): Point
    {
        return new Point($this->_transform2D->cx->emu, $this->_transform2D->cy->emu);
    }

    /**
     * 绝对大小
     * @return Point
     */
    protected function getAbsSize(): Point
    {
        $scale = $this->getAbsScale();
        $size = $this->getSize();

        return $size->scale($scale);
    }

    protected function getOffset(): Point
    {
        return new Point($this->_transform2D->x->emu, $this->_transform2D->y->emu);
    }

    /**
     * 获取在父级坐标系中的绝对坐标
     * @return Point
     */
    protected function getInheritOffset(): Point
    {
        $center = $this->getAbsCenter();
        $size = $this->getAbsSize();
        //echo sprintf("中心点位置: %s 宽高: %s\n", $center, $size);
        return $center->move(new Point(-$size->x / 2, -$size->y / 2));
    }

    /**
     * 获取中心点绝对坐标
     * @return Point
     */
    protected function getAbsCenter(): Point
    {
        $center = $this->getSize()->getCenter();

        // 中心点不受反转、旋转等影响
        return $this->calInheritPoint($center);
    }

    protected function getChildOffset(): ?Point
    {
        if (!$this->_transform2D->chOff) {
            return null;
        }
        return new Point($this->_transform2D->chOff->x->emu, $this->_transform2D->chOff->y->emu);
    }

    protected function getChildSize(): ?Point
    {
        if (!$this->_transform2D->chExt) {
            return null;
        }
        return new Point($this->_transform2D->chExt->cx->emu, $this->_transform2D->chExt->cy->emu);
    }

    protected function getRotation(): float
    {
        return $this->_transform2D->rot ?: 0.0;
    }

    protected function getAbsRotation(): float
    {
        return $this->rotation + $this->getInheritRotation();
    }

    protected function getInheritRotation(): float
    {
        return $this->_parent ? $this->_parent->absRotation : 0.0;
    }

    protected function getFlipV(): bool
    {
        return $this->_transform2D->flipV;
    }

    protected function getFlipH(): bool
    {
        return $this->_transform2D->flipH;
    }

    protected function getScale(): Point
    {
        $size = $this->getSize();
        $childSize = $this->getChildSize();

        if (!$childSize) {
            return new Point(1.0,1.0);
        }

        $scaleX = $childSize->x > 0 ? $size->x / $childSize->x : 1.0;
        $scaleY = $childSize->y > 0 ? $size->y / $childSize->y : 1.0;
        return new Point($scaleX, $scaleY);
    }

    protected function getAbsScale(): Point
    {
        $scale = $this->getScale();
        $parentScale = $this->_parent ? $this->_parent->getAbsScale() : new Point(1.0,1.0);

        return $scale->scale($parentScale);
    }

    protected function getInheritScale(): Point
    {
        return $this->_parent ? $this->_parent->getAbsScale() : new Point(1.0,1.0);
    }

    public function toArray(): array
    {
        $offset = $this->getInheritOffset();
        $size = $this->getAbsSize();

        return [
            'left' => $offset->lx->htmlVal,
            'top' => $offset->ly->htmlVal,
            'width' => $size->lx->htmlVal,
            'height' => $size->ly->htmlVal,
            'rotate' => $this->getAbsRotation(),
        ];
    }
}