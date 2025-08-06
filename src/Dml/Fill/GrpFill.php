<?php

namespace Imoing\Pptx\Dml\Fill;

use Imoing\Pptx\Enum\MsoFillType;
use Imoing\Pptx\OXml\Dml\Fill\CTGroupFillProperties;

class GrpFill extends Fill
{
    private CTGroupFillProperties $_xFill;

    public function __construct(CTGroupFillProperties $xFill)
    {
        parent::__construct($xFill);
        $this->_xFill = $xFill;
    }
    public function getType(): MsoFillType
    {
        return MsoFillType::GROUP;
    }

    public function toArray(): array
    {
        return [];
    }
}