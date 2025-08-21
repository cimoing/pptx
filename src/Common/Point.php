<?php

namespace Imoing\Pptx\Common;

use Imoing\Pptx\Util\Emu;
use Imoing\Pptx\Util\Length;

/**
 * @property float $x
 * @property float $y
 * @property-read Length $lx
 * @property-read Length $ly
 */
class Point extends BaseObject
{
    protected float $_x;

    protected float $_y;

    public function __construct(float $x, float $y)
    {
        parent::__construct([]);
        $this->_x = $x;
        $this->_y = $y;
    }

    /**
     * 移动点
     * @param Point $point
     * @return $this
     */
    public function move(Point $point): self
    {
        $this->_x += $point->x;
        $this->_y += $point->y;
        return $this;
    }

    /**
     * 获取旋转后的点
     * @param float $degree 旋转角度
     * @param Point $center 中心点
     * @return self
     */
    public function rotate(float $degree, Point $center): self
    {
        if ($degree == 0.0) {
            return $this;
        }

        $radians = deg2rad($degree);

        // 获取原点坐标
        $tX = $this->_x - $center->x;
        $tY = $this->_y - $center->y;

        // 旋转
        $rX = $tX * cos($radians) - $tY * sin($radians);
        $rY = $tX * sin($radians) + $tY * cos($radians);
        $this->_x = $rX + $center->x;
        $this->_y = $rY + $center->y;
        return $this;
    }

    /**
     * 获取中心点
     * @param ?Point $relative 默认相对于原点
     * @return $this
     */
    public function getCenter(?Point $relative = null): self
    {
        if (!$relative) {
            $relative = new Point(0, 0);
        }
        return new static(
            ($this->_x + $relative->x) / 2,
            ($this->_y + $relative->y) / 2
        );
    }

    public function getX(): float
    {
        return $this->_x;
    }

    public function setX(float $val): void
    {
        $this->_x = $val;
    }

    public function getLx(): Length
    {
        return new Emu((int) $this->_x);
    }

    public function getLy(): Length
    {
        return new Emu((int) $this->_y);
    }

    public function getY(): float
    {
        return $this->_y;
    }

    public function setY(float $val): void
    {
        $this->_y = $val;
    }

    public function flipV(Point $center): self
    {
        $this->_y = $center->y - ($this->_y - $center->y);
        return $this;
    }

    public function flipH(Point $center): self
    {
        $this->_x = $center->x - ($this->_x - $center->x);
        return $this;
    }

    public function scale(Point $scale): self
    {
        $this->_x *= $scale->x;
        $this->_y *= $scale->y;
        return $this;
    }

    public function __toString(): string
    {
        return sprintf("(%d,%d)", $this->getLx()->htmlVal, $this->getLy()->htmlVal);
    }
}