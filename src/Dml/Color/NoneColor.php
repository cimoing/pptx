<?php

namespace Imoing\Pptx\Dml\Color;

use Imoing\Pptx\Enum\MsoColorType;
use Imoing\Pptx\Enum\MsoThemeColorIndex;

class NoneColor extends Color
{

    public function getColorType(): ?MsoColorType
    {
        return null;
    }

    public function getThemeColor(): MsoThemeColorIndex
    {
        throw new \Exception(sprintf("no .theme_color property on color type '%s'", __CLASS__));
    }
}