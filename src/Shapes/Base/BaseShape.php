<?php

namespace Imoing\Pptx\Shapes\Base;

use Imoing\Pptx\Common\BaseObject;
use Imoing\Pptx\Dml\Effect\ShadowFormat;
use Imoing\Pptx\Enum\MsoShapeType;
use Imoing\Pptx\OXml\Shapes\Shared\BaseShapeElement;
use Imoing\Pptx\Parts\Slide\BaseSlidePart;
use Imoing\Pptx\Types\ProvidesPart;
use Imoing\Pptx\Util\Length;

/**
 * @property-read BaseShapeElement $element
 * @property-read $clickAction
 * @property-read bool $hasChart
 * @property-read bool $hasTable
 * @property-read bool $hasTextFrame
 * @property Length $height
 * @property Length $left
 * @property Length $top
 * @property Length $width
 * @property bool $flipV
 * @property bool $flipH
 * @property-read bool $isPlaceholder
 * @property string $name
 * @property-read BaseSlidePart $part
 * @property-read PlaceholderFormat $placeholderFormat
 * @property float $rotation
 * @property-read ShadowFormat $shadow
 * @property-read int $shapeId
 * @property-read  MsoShapeType $shapeType
 *
 */
abstract class BaseShape extends BaseObject implements ProvidesPart
{
    protected ?BaseShapeElement $_element;
    protected ProvidesPart $_parent;
    public function __construct(BaseShapeElement $shapeElement, ProvidesPart $parent)
    {
        parent::__construct([]);
        $this->_element = $shapeElement;
        $this->_parent = $parent;
    }

    public function getElement(): BaseShapeElement
    {
        return $this->_element;
    }

    public function equals($object): bool
    {
        if (!($object instanceof BaseShape)) {
            return false;
        }

        return $this->element === $object->element;
    }

    public function getHasChart(): bool
    {
        return false;
    }

    public function getHasTable(): bool
    {
        return false;
    }

    public function getHasTextFrame(): bool
    {
        return false;
    }

    public function getHeight(): Length
    {
        return $this->_element->cy;
    }

    public function setHeight(Length $height): void
    {
        $this->_element->cy = $height;
    }

    public function getLeft(): Length
    {
        return $this->_element->x;
    }

    public function setLeft(Length $left): void
    {
        $this->_element->x = $left;
    }

    public function getTop(): Length
    {
        return $this->_element->y;
    }

    public function setTop(Length $top): void
    {
        $this->_element->y = $top;
    }

    public function getWidth(): Length
    {
        return $this->_element->cx;
    }

    public function setWidth(Length $width): void
    {
        $this->_element->cx = $width;
    }

    public function getFlipV(): bool
    {
        return $this->_element->flipV;
    }

    public function setFlipV(bool $flipV): void
    {
        $this->_element->flipV = $flipV;
    }

    public function getFlipH(): bool
    {
        return $this->_element->flipH;
    }

    public function setFlipH(bool $flipH): void
    {
        $this->_element->flipH = $flipH;
    }

    public function isPlaceholder(): bool
    {
        return $this->_element->hasPhElm;
    }

    public function getName(): string
    {
        return $this->_element->shapeName;
    }

    public function setName(string $name): void
    {
        $this->_element->nvXxPr->cNvPr->name = $name;
    }

    public function getPart(): BaseSlidePart
    {
        $part = $this->_parent->getPart();
        assert($part instanceof BaseSlidePart);
        return $part;
    }

    public function getPlaceholderFormat(): PlaceholderFormat
    {
        $ph = $this->_element->ph;
        if (empty($ph)) {
            throw new \Exception("shape is not a placeholder");
        }

        return new PlaceholderFormat($ph);
    }

    public function getRotation(): float
    {
        return $this->_element->rot;
    }

    public function setRotation(float $rotation): void
    {
        $this->_element->rot = $rotation;
    }

    public function getShadow(): ShadowFormat
    {
        return new ShadowFormat($this->_element->spPr);
    }

    public function getShapeId(): int
    {
        return $this->_element->shapeId;
    }

    abstract public function getShapeType(): MsoShapeType;

    public function getTextArr(): array
    {
        return [

        ];
    }

    public function getOutlineArr(): array
    {
        return [];
    }

    public function getShadowArr(): ?array
    {
        return [

        ];
    }

    public function toArray(): array
    {
        $fill = $this->_element->getFill() ? $this->_element->getFill()->toArray() : null;

        if (!empty($fill) && $fill['type'] == 'scheme') {
            $theme = $this->_parent->getColorScheme();
            $fill = [
                'type' => 'color',
                'color' => $theme[$fill['scheme']],
            ];
        }

        return [
            'id' => $this->shapeId,
            'left' => $this->left->pt,
            'top' => $this->top->pt,
            'width' => $this->width->pt,
            'height' => $this->height->pt,
            'rotate' => $this->rotation,
            'fill' => $fill,
            'outline' => $this->getOutlineArr(),
            'text' => $this->getTextArr(),
            'flipH' => $this->flipH,
            'flipV' => $this->flipV,
            'name' => $this->name,
        ];
    }

}