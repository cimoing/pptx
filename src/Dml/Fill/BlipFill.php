<?php

namespace Imoing\Pptx\Dml\Fill;

use Imoing\Pptx\Enum\MsoFillType;

class BlipFill extends Fill
{
    public function getType(): ?\Imoing\Pptx\Enum\MsoFillType
    {
        return MsoFillType::PICTURE;
    }
}