<?php

namespace Imoing\Pptx\Dml\Fill;

/**
 * @property $type
 */
class NoneFill extends Fill
{
    public function getType(): ?\Imoing\Pptx\Enum\MsoFillType
    {
        return null;
    }
}