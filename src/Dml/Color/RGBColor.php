<?php

namespace Imoing\Pptx\Dml\Color;

use Imoing\Pptx\Common\BaseObject;

/**
 * @property int $r
 * @property int $g
 * @property int $b
 * @property int $a
 */
class RGBColor extends BaseObject
{
    public function __construct(int $r, int $g, int $b)
    {
        parent::__construct();
        $this->r = $r;
        $this->g = $g;
        $this->b = $b;
    }

    public static function create(int $r, int $g, int $b): RGBColor
    {
        foreach([$r, $g, $b] as $color) {
            if ($color < 0 || $color > 255) {
                throw new \Exception("RGBColor() takes three integer values 0-255");
            }
        }

        return new RGBColor($r, $g, $b);
    }

    public static function fromString(string $rgbHexStr): RGBColor
    {
        $r = intval(substr($rgbHexStr,0,2), 16);
        $g = intval(substr($rgbHexStr,2,2), 16);
        $b = intval(substr($rgbHexStr,4,2), 16);
        return new RGBColor($r, $g, $b);
    }


    public function __toString(): string
    {
        return sprintf('%02X%02X%02X', $this->r, $this->g, $this->b);
    }
}