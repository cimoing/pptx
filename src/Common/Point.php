<?php

namespace Imoing\Pptx\Common;

use Imoing\Pptx\Util\Emu;
use Imoing\Pptx\Util\Length;

/**
 * @property-read int $x
 * @property-read int $y
 * @property-read Length $lx
 * @property-read Length $ly
 */
class Point extends BaseObject
{
    private int $_x;

    private int $_y;

    public function __construct(int $x, int $y)
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

        $radians = deg2rad($degree);

        // 获取原点坐标
        $tX = $this->_x - $center->x;
        $tY = $this->_y - $center->y;

        // 旋转
        $rX = $tX * cos($radians) - $tY * sin($radians);
        $rY = $tX * sin($radians) + $tY * cos($radians);

        // 获取旋转后的点
        return new static(intval($rX + $center->x), intval($rY + $center->y));
    }

    /**
     * 获取中心点
     * @param Point $relative
     * @return $this
     */
    public function getCenter(Point $relative): self
    {
        return new static(
            intval(($this->_x + $relative->x) / 2),
            intval(($this->_y + $relative->y) / 2)
        );
    }

    public function getX(): int
    {
        return $this->_x;
    }

    public function getLx(): Length
    {
        return new Emu($this->_x);
    }

    public function getLy(): Length
    {
        return new Emu($this->_y);
    }

    public function getY(): int
    {
        return $this->_y;
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

    public function __toString(): string
    {
        return sprintf("(%d,%d)", $this->getLx()->htmlVal, $this->getLy()->htmlVal);
    }
}