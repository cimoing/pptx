<?php

namespace Imoing\Pptx\Dml\Color;

use Imoing\Pptx\Common\BaseObject;
use Imoing\Pptx\Enum\MsoColorType;
use Imoing\Pptx\Enum\MsoThemeColorIndex;
use Imoing\Pptx\OXml\Dml\Color\BaseColorElement;
use Imoing\Pptx\OXml\Dml\Color\CTHslColor;
use Imoing\Pptx\OXml\Dml\Color\CTPresetColor;
use Imoing\Pptx\OXml\Dml\Color\CTSchemeColor;
use Imoing\Pptx\OXml\Dml\Color\CTScRgbColor;
use Imoing\Pptx\OXml\Dml\Color\CTSRgbColor;
use Imoing\Pptx\OXml\Dml\Color\CTSystemColor;

/**
 * @property float $brightness
 * @property-read ?MsoColorType $colorType
 * @property RGBColor $rgb
 * @property MsoThemeColorIndex $themeColor
 */
abstract class Color extends BaseObject
{
    /**
     * @var ?BaseColorElement
     */
    protected mixed $_xClr;

    public function __construct(?BaseColorElement $xClr)
    {
        parent::__construct();
        $this->_xClr = $xClr;
    }
    public static function create($xClr): Color
    {
        $clsMaps = [
            null => NoneColor::class,
            CTHslColor::class => HslColor::class,
            CTPresetColor::class => PrstColor::class,
            CTSchemeColor::class => SchemeColor::class,
            CTScRgbColor::class => SCRgbColor::class,
            CTSRgbColor::class => SRGBColor::class,
            CTSystemColor::class => SysColor::class,
        ];

        $cls = $clsMaps[is_null($xClr) ? null : get_class($xClr)] ?? NoneColor::class;
        return new $cls($xClr);
    }

    public function getBrightness(): float
    {
        list($lumMod, $lumOff) = [$this->_xClr->lumMod, $this->_xClr->lumOff];

        if (!is_null($lumOff)) {
            return $lumOff->nodeValue;
        }

        if (!is_null($lumMod)) {
            return $lumMod->nodeValue - 1.0;
        }

        return 0.0;
    }

    public function setBrightness(float $value): void
    {
        if ($value > 0) {
            $this->tint($value);
        } else if ($value < 0) {
            $this->shade($value);
        } else {
            $this->_xClr->clear_lum();
        }
    }

    abstract public function getColorType(): ?MsoColorType;

    public function getRgb(): RGBColor
    {
        throw new \Exception(sprintf("no .rgb property on color type '%s'", __CLASS__));
    }

    public function getThemeColor(): MsoThemeColorIndex
    {
        return MsoThemeColorIndex::NOT_THEME_COLOR;
    }


    protected function shade(float $value): void
    {
        $lumModVal = 1.0 - abs($value);
        $colorElm = $this->_xClr->clear_lum();
        $colorElm->add_lumMod($lumModVal);
    }

    protected function tint(float $value): void
    {
        $lumOffVal = $value;
        $lumModVal = 1.0 - $lumOffVal;
        $colorElm = $this->_xClr->clear_lum();
        $colorElm->add_lumMod($lumModVal);
        $colorElm->add_lumOff($lumOffVal);
    }
}