<?php

namespace Imoing\Pptx\Dml\Color;

use Imoing\Pptx\Enum\MsoColorType;

class SysColor extends Color
{
    public function getColorType(): ?MsoColorType
    {
        return MsoColorType::SYSTEM;
    }
}