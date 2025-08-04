<?php

namespace Imoing\Pptx\Dml\Color;

use Imoing\Pptx\Enum\MsoColorType;

class HslColor extends Color
{

    public function getColorType(): ?MsoColorType
    {
        return MsoColorType::HSL;
    }
}