<?php

namespace Imoing\Pptx\Dml\Color;

use Imoing\Pptx\Common\BaseObject;
use Imoing\Pptx\Enum\MsoColorType;
use Imoing\Pptx\Enum\MsoThemeColorIndex;

/**
 * @property float $brightness
 * @property RGBColor|SRgbColor $rgb
 * @property ?MsoThemeColorIndex $themeColor
 * @property ?MsoColorType $type
 */
class ColorFormat extends BaseObject
{
    protected $_xFill;
    /**
     * @var Color
     */
    protected Color $_color;
    public function __construct($egColorChoiceParent, $color)
    {
        parent::__construct();
        $this->_xFill = $egColorChoiceParent;
        $this->_color = $color;
    }

    public static function fromColorChoiceParent($egColorChoiceParent): ColorFormat
    {
        $xClr = $egColorChoiceParent->eg_colorChoice;
        $color = Color::create($xClr);
        return new self($egColorChoiceParent, $color);
    }

    public function getBrightness(): float
    {
        return $this->_color->brightness;
    }

    public function setBrightness(float $brightness): void
    {
        $this->validateBrightnessValue($brightness);
        $this->_color->brightness = $brightness;
    }

    public function getRgb(): RGBColor
    {

        return $this->_color->rgb;
    }

    public function setRgb(RGBColor $rgb): void
    {
        if (!($this->_color instanceof SRgbColor)) {
            $srgbClr = $this->_xFill->get_or_change_to_srgbClr();
            $this->_color = new SRgbColor($srgbClr);
        }
        $this->_color->rgb = $rgb;
    }

    public function getThemeColor(): ?MsoThemeColorIndex
    {
        return $this->_color->themeColor;
    }

    public function isThemeColor(): bool
    {
        return !($this->themeColor === MsoThemeColorIndex::NOT_THEME_COLOR);
    }

    public function setThemeColor(MsoThemeColorIndex $themeColor): void
    {
        if (!($this->_color instanceof SchemeColor)) {
            $schemeClr = $this->_xFill->get_or_change_to_schemeClr();
            $this->_color = new SchemeColor($schemeClr);
        }
        $this->_color->themeColor = $themeColor;
    }

    public function getType(): ?MsoColorType
    {
        return $this->_color->colorType;
    }

    public function setType(?MsoColorType $type): void
    {
        $this->type = $type;
    }



    private function validateBrightnessValue($value): void
    {
        if ($value < -1.0 || $value > 1.0) {
            throw new \Exception("brightness must be number in range -1.0 to 1.0");
        }
        if ($this->_color instanceof NoneColor) {
            throw new \Exception("can't set brightness when color.type is None. Set color.rgb  or .theme_color first.");
        }
    }

    public function toArray(): array
    {
        if (empty($this->type)) {
            return [
                'type' => 'none',
            ];
        }
        return $this->isThemeColor() ? [
            'type' => 'scheme',
            'scheme' => $this->themeColor->getXmlValue(),
        ] : [
            'type' => 'color',
            'color' => (string) $this->getRgb(),
        ];
    }
}