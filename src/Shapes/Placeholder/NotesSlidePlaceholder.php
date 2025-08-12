<?php

namespace Imoing\Pptx\Shapes\Placeholder;

use Imoing\Pptx\Enum\MsoShapeType;
use Imoing\Pptx\Shapes\Base\BaseShape;

class NotesSlidePlaceholder extends BaseShape
{
    use InheritsDimensions;

    public function getShapeType(): MsoShapeType
    {
        return MsoShapeType::PLACEHOLDER;
    }

    protected function getBasePlaceholder(): mixed
    {
        $notesMaster = $this->part->notesMaster;
        $phType = $this->_element->phType;

        return $notesMaster->pladeholders->getByType($phType);
    }
}