<?php

namespace Imoing\Pptx\Dml\Effect;

use Imoing\Pptx\Common\BaseObject;
use Imoing\Pptx\Dml\Color\ColorFormat;
use Imoing\Pptx\Dml\Fill\FillFormat;
use Imoing\Pptx\OXml\Shapes\Shared\CTShapeProperties;
use Imoing\Pptx\Shapes\Base\Theme;

/**
 * @property bool $inherit
 */
class ShadowFormat extends BaseObject
{
    /**
     * @var mixed|CTShapeProperties
     */
    protected mixed $_element;

    protected ?Theme $_theme;
    public function __construct($spPr, ?Theme $theme)
    {
        parent::__construct([]);
        $this->_element = $spPr;
        $this->_theme = $theme;
    }

    public function getInherit(): bool
    {
        if (empty($this->_element->effectLst)) {
            return true;
        }

        return false;
    }

    public function setInherit(bool $inherit): void
    {
        if ($inherit) {
            $this->_element->_remove_effectLst();
        } else {
            $this->_element->get_or_add_effectLst();
        }
    }

    public function toArray(): ?array
    {
        if (!$this->_element->effectLst || !$this->_element->effectLst->outerShdw) {
            return null;
        }

        $shadow = $this->_element->effectLst->outerShdw;
        $color = ColorFormat::fromColorChoiceParent($shadow, $this->_theme);

        $direction = $shadow->dir ?: 0;
        $distance = $shadow->dist?->px ?: 0;
        $blurRad = $shadow->blurRad?->px ?: '';

        return [
            'h' => $distance * cos($direction * M_PI / 180),
            'v' => $distance * sin($direction * M_PI / 180),
            'blur' => $blurRad,
            'color' => $color->toArray(),
        ];
    }
}