<?php

namespace Imoing\Pptx\Shapes;

use Imoing\Pptx\Common\Point;
use Imoing\Pptx\Dml\Fill\FillFormat;
use Imoing\Pptx\Enum\MsoShapeType;
use Imoing\Pptx\OXml\Shapes\GroupShape\CTGroupShape;
use Imoing\Pptx\Shapes\Base\BaseShape;
use Imoing\Pptx\Shapes\ShapeTree\ShapeTree;
use Imoing\Pptx\Types\ProvidesPart;
use Imoing\Pptx\Util\Emu;
use Imoing\Pptx\Util\Length;

/**
 * @property Length[] $childOff
 */
class GroupShape extends BaseShape implements \IteratorAggregate
{
    private CTGroupShape $_sp;
    public function __construct(CTGroupShape $shapeElement, ProvidesPart $part)
    {
        parent::__construct($shapeElement, $part);
        $this->_sp = $shapeElement;
    }
    public function getShapeType(): MsoShapeType
    {
        return MsoShapeType::GROUP;
    }

    private ?FillFormat $_fill = null;
    public function getFill(): FillFormat
    {
        if (is_null($this->_fill)) {
            $this->_fill = FillFormat::fromFillParent($this->_sp->grpSpPr);
        }

        return $this->_fill;
    }

    /**
     * @return \Traversable<int,BaseShape>
     */
    public function getIterator(): \Traversable
    {
        foreach ($this->_sp->iter_shape_elms() as $elm) {
            yield ShapeTree::baseShapeFactory($elm, $this);
        }
    }

    public function getSchemeColor(string $scheme): string
    {
        return $this->_parent->getSchemeColor($scheme);
    }

    public function toArray(): array
    {
        $arr = parent::toArray();

        $elements = [];
        foreach ($this as $elm) {
            $elements[] = $elm->toArray();
        }
        return array_merge($arr, [
            'elements' => $elements,
        ]);
    }
}