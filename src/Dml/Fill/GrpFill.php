<?php

namespace Imoing\Pptx\Dml\Fill;

use Imoing\Pptx\Enum\MsoFillType;
use Imoing\Pptx\OXml\Dml\Fill\CTGroupFillProperties;
use Imoing\Pptx\Shapes\Base\Theme;

class GrpFill extends Fill
{
    private CTGroupFillProperties $_xFill;

    public function __construct(CTGroupFillProperties $xFill, ?Theme $theme = null)
    {
        parent::__construct($xFill, $theme);
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