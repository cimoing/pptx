<?php

namespace Imoing\Pptx\Dml\Line;

use Imoing\Pptx\Common\BaseObject;
use Imoing\Pptx\Dml\Color\ColorFormat;
use Imoing\Pptx\Dml\Fill\FillFormat;
use Imoing\Pptx\Enum\MsoFillType;
use Imoing\Pptx\OXml\Shapes\Shared\CTLineProperties;
use Imoing\Pptx\Shapes\Picture\BasePicture;
use Imoing\Pptx\Util\Emu;
use Imoing\Pptx\Util\Length;

/**
 * @property-read ColorFormat $color
 * @property ?string $dashStyle
 * @property-read FillFormat $fill
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

    private ?ColorFormat $_color = null;

    /**
     * @return ColorFormat
     */
    public function getColor(): ColorFormat
    {
        if (is_null($this->_color)) {
            if ($this->fill->type != MsoFillType::SOLID) {
                $this->fill->solid();
            }
            $this->_color = $this->fill->foreColor;
        }

        return $this->_color;
    }

    public function getDashStyle(): ?string
    {
        $ln = $this->getLn();
        if (is_null($ln)) {
            return null;
        }

        return $ln->prstDashVal?->getXmlValue();
    }

    public function setDashStyle(?string $dashStyle): void
    {
        if (is_null($dashStyle)) {
            $ln = $this->getLn();
            if (is_null($ln)) {
                return;
            }

            $ln->_remove_prstDash();
            $ln->_remove_custDash();
            return;
        }

        $ln = $this->get_or_add_ln();
        $ln->prstDashVal = $dashStyle;
    }

    private ?FillFormat $_fill = null;

    /**
     * @return FillFormat
     */
    public function getFill(): FillFormat
    {
        if (is_null($this->_fill)) {
            $ln = $this->get_or_add_ln();
            $this->_fill = FillFormat::fromFillParent($ln);
        }

        return $this->_fill;
    }

    public function getWidth(): Length
    {
        $ln = $this->getLn();
        if (is_null($ln)) {
            return new Emu(0);
        }

        return $ln->w;
    }

    public function setWidth(?Length $width): void
    {
        if ($width === null) {
            $width  = new Emu(0);
        }
        $ln = $this->get_or_add_ln();
        $ln->w = $width;
    }

    private function get_or_add_ln(): CTLineProperties
    {
        return $this->_parent->get_or_add_ln();
    }

    protected function getLn(): ?CTLineProperties
    {
        return $this->_parent->ln;
    }

    public function toArray(): array
    {
        $color = $this->color->toArray();
        $prstDashVal = $this->dashStyle ?: 'solid';
        list($borderType, $strokeDash) = match ($prstDashVal) {
            'dash' => ['dashed', '5'],
            'dashDot' => ['dashed', '5, 5, 1, 5'],
            'dot' => ['dotted', '1, 5'],
            'lgDash' => ['dashed', '1, 5'],
            'lgDashDot' => ['dashed', '10, 5'],
            'lgDashDotDot' => ['dashed', '10, 5, 1, 5, 1, 5'],
            'sysDash' => ['dashed', '5, 2'],
            'sysDashDot' => ['dotted', '5, 2, 1, 5, 1, 5'],
            'sysDot' => ['dotted', '2, 5'],
            default => ['solid', '0'],
        };

        return [
            'color' => $color,
            'width' => $this->width->getPt(),
            'style' => $borderType,
        ];
    }
}