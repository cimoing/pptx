<?php

namespace Imoing\Pptx\Shapes;

use Imoing\Pptx\Enum\MsoShapeType;
use Imoing\Pptx\Shapes\Base\BaseShape;

class GroupShape extends BaseShape
{
    public function getShapeType(): MsoShapeType
    {
        return MsoShapeType::GROUP;
    }
}