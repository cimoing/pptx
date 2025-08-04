<?php

namespace Imoing\Pptx\Dml\Line;

use Imoing\Pptx\Common\BaseObject;
use Imoing\Pptx\Shapes\Picture\BasePicture;
use Imoing\Pptx\Util\Length;

/**
 * @property-read $color
 * @property string $dashStyle
 * @property-read $fill
 * @property Length $width
 */
class LineFormat extends BaseObject
{
    /**
     * @var mixed|BasePicture
     */
    protected mixed $_parent;
    public function __construct($parent)
    {
        parent::__construct([]);
        $this->_parent = $parent;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     */
    public function setColor($color): void
    {
        $this->color = $color;
    }

    public function getDashStyle(): string
    {
        return $this->dashStyle;
    }

    public function setDashStyle(string $dashStyle): void
    {
        $this->dashStyle = $dashStyle;
    }

    private $_fill;
    /**
     * @return mixed
     */
    public function getFill()
    {
        if (is_null($this->_fill)) {
            $ln = $this->get_or_add_ln();
            $this->_fill = FillFormat::fromFillParent($ln);
        }

        return $this->_fill;
    }

    public function getWidth(): Length
    {
        return $this->width;
    }

    public function setWidth(Length $width): void
    {
        $this->width = $width;
    }

    private function get_or_add_ln(): \Imoing\Pptx\OXml\Shapes\Shared\CTLineProperties
    {
        return $this->_parent->get_or_add_ln();
    }

    protected function getLn(): \Imoing\Pptx\OXml\Shapes\Shared\CTLineProperties
    {
        return $this->_parent->ln;
    }
}