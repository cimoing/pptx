<?php

namespace Imoing\Pptx\Dml\Fill;

use Imoing\Pptx\Enum\MsoFillType;
use Imoing\Pptx\OXml\Dml\Fill\CTBlipFillProperties;

/**
 * @property-read CTBlipFillProperties $_xFill
 */
class BlipFill extends Fill
{
    public function getType(): ?\Imoing\Pptx\Enum\MsoFillType
    {
        return MsoFillType::PICTURE;
    }

    public function toArray(): array
    {
        return [
            'type' => 'image',
            'image' => [
                'rId' => $this->_xFill?->blip?->rEmbed,
                'opacity' => 0,
            ],
        ];
    }
}