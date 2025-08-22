<?php

namespace Imoing\Pptx\Text\Text;

use Imoing\Pptx\Common\BaseObject;
use Imoing\Pptx\Dml\Color\Color;
use Imoing\Pptx\Dml\Color\ColorFormat;
use Imoing\Pptx\Dml\Fill\FillFormat;
use Imoing\Pptx\Enum\MsoColorType;
use Imoing\Pptx\Enum\MsoFillType;
use Imoing\Pptx\Enum\MsoTextStrikeType;
use Imoing\Pptx\Enum\MsoTextUnderlineType;
use Imoing\Pptx\OXml\Dml\Fill\CTLevelParaProperties;
use Imoing\Pptx\OXml\Text\CTTextCharacterProperties;
use Imoing\Pptx\Shapes\Base\Theme;
use Imoing\Pptx\Util\Centipoints;
use Imoing\Pptx\Util\Length;

/**
 * @property-read ColorFormat $color
 * @property-read FillFormat $fill
 * @property ?bool $bold
 * @property ?Length $size
 * @property ?string $name
 * @property ?bool $italic
 * @property MsoTextUnderlineType|bool|null $underline
 * @property ?MsoTextStrikeType $strike
 */
class Font extends BaseObject
{
    private CTTextCharacterProperties $_element;
    private CTTextCharacterProperties $_rPr;

    private ?CTLevelParaProperties $_lvlPPr;

    protected ?Theme $_theme;

    public function __construct(CTTextCharacterProperties $rPr, ?CTLevelParaProperties $lvlPPr = null, ?Theme $theme = null)
    {
        parent::__construct([]);
        $this->_element = $this->_rPr = $rPr;
        $this->_lvlPPr = $lvlPPr;
        $this->_theme = $theme;
    }

    public function getBold(): ?bool
    {
        return $this->_rPr->b;
    }

    public function setBold(?bool $value): void
    {
        $this->_rPr->b = $value;
    }

    private ?ColorFormat $_color = null;
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

    private ?FillFormat  $_fill = null;
    public function getFill(): FillFormat
    {
        if (!$this->_fill) {
            $this->_fill = FillFormat::fromFillParent($this->_rPr, $this->_theme);
        }

        return $this->_fill;
    }

    public function getItalic(): ?bool
    {
        return $this->_rPr->i;
    }

    public function setItalic(?bool $value): void
    {
        $this->_rPr->i = $value;
    }

    public function getName(): ?string
    {
        $latin = $this->_rPr->latin;
        return empty($latin) ? null : $latin->typeface;
    }

    public function setName(?string $value): void
    {
        if (is_null($value)) {
            $this->_rPr->_remove_latin();
        } else {
            $this->_rPr->get_or_add_latin()->typeface = $value;
        }
    }

    public function getSize(): ?Length
    {
        $sz = $this->_rPr->sz;
        return empty($sz) ? null : $sz;
    }

    public function setSize(?Length $value): void
    {
        if (is_null($value)) {
            $this->_rPr->sz = null;
        } else {
            $this->_rPr->sz = $value;
        }
    }

    /**
     * @return bool|MsoTextUnderlineType|null
     */
    public function getUnderline(): MsoTextUnderlineType|bool|null
    {
        $u = $this->_rPr->u;
        if ($u == MsoTextUnderlineType::NONE) {
            return false;
        }

        if ($u == MsoTextUnderlineType::SINGLE_LINE) {
            return true;
        }

        return $u;
    }

    public function setUnderline(MsoTextUnderlineType|bool|null $value): void
    {
        if ($value === false) {
            $value = MsoTextUnderlineType::NONE;
        } elseif ($value === true) {
            $value = MsoTextUnderlineType::SINGLE_LINE;
        }

        $this->_rPr->u = $value;
    }

    public function getStrike(): ?MsoTextStrikeType
    {
        return $this->_rPr->strike;
    }

    public function setStrike(?MsoTextStrikeType $value): void
    {
        $this->_rPr->strike = $value;
    }

    public function toHtmlStyle(): array
    {
        $defaultPPr = $this->_lvlPPr?->defRPr;
        $defaultArr = [];
        if ($defaultPPr) {
            $defaultArr = (new static($defaultPPr, null, $this->_theme))->toHtmlStyle();
        }

        $color = $this->getColor()->toArray();
        $curr = array_filter([
            'color' => $color['type'] === 'color' ? $color['color'] : null,
            'font-size' => $this->size ? $this->size->px . 'px' : null,
            'font-family' => $this->name,
            'font-bold' => $this->bold ? 'bold' : null,
            'font-style' => $this->italic ? 'italic' : null,
            'text-decoration' => $this->underline === true ? 'underline' : null,
            'text-decoration-line' => $this->strike === MsoTextStrikeType::SINGLE ? 'line-through' : null,
        ], function ($v) {
            return !is_null($v);
        });
        return array_merge($defaultArr,$curr);
    }
}