<?php

namespace Imoing\Pptx\OXml\Dml\Color;

use Imoing\Pptx\OXml\SimpleTypes\XsdInt;
use Imoing\Pptx\OXml\XmlChemy\RequiredAttribute;

/**
 * @property int $hue
 * @property int $sat
 * @property int $lum
 */
class CTHslColor extends BaseColorElement
{
    #[RequiredAttribute("hue", XsdInt::class)]
    protected int $_hue;

    #[RequiredAttribute("sat", XsdInt::class)]
    protected int $_sat;

    #[RequiredAttribute("lum", XsdInt::class)]
    protected int $_lum;

    public function getHexValue(): string
    {
        $h = intval($this->hue / 21600000 * 360);
        $s = intval($this->sat / 100000);
        $l = intval($this->lum / 100000);

        $c = intval((1 - abs(2 * $l - 1)) * $s);
        $x = $c * (1 - abs(intval($h / 60)) % 2 - 1);
        $m = intval($l - $c / 2);

        if (0 <= $h && $h < 60) {
            list($r, $g, $b) = [$c, $x, 0];
        } else if (60 <= $h && $h < 120) {
            list($r, $g, $b) = [$x, $c, 0];
        } else if (120 <= $h && $h < 180) {
            list($r, $g, $b) = [0, $c, $x];
        } else if (180 <= $h && $h < 240) {
            list($r, $g, $b) = [0, $x, $c];
        } else if (240 <= $h && $h < 300) {
            list($r, $g, $b) = [$x, 0, $c];
        } else {
            list($r, $g, $b) = [$c, 0, $x];
        }

        list($r, $g, $b) = [intval(($r + $m) * 255), intval(($g + $m) * 255), intval(($b + $m) * 255)];

        return sprintf('%02x%02x%02x', $r, $g, $b);

    }
}