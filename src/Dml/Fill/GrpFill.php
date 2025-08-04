<?php

namespace Imoing\Pptx\Dml\Fill;

use Imoing\Pptx\Enum\MsoFillType;

class GrpFill extends Fill
{
    public function getType(): MsoFillType
    {
        return MsoFillType::GROUP;
    }
}