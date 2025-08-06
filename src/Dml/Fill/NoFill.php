<?php

namespace Imoing\Pptx\Dml\Fill;

use Imoing\Pptx\Enum\MsoFillType;

class NoFill extends Fill
{
    public function getType(): ?MsoFillType
    {
        return MsoFillType::BACKGROUND;
    }

    public function toArray(): array
    {
        return [
            'type' => 'none',
        ];
    }
}