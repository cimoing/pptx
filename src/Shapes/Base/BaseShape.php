<?php

namespace Imoing\Pptx\Shapes\Base;

use Imoing\Pptx\Common\BaseObject;
use Imoing\Pptx\Dml\Effect\ShadowFormat;
use Imoing\Pptx\Dml\Fill\FillFormat;
use Imoing\Pptx\Enum\MsoShapeType;
use Imoing\Pptx\OXml\Shapes\Shared\BaseShapeElement;
use Imoing\Pptx\OXml\Shapes\Shared\CTPoint2D;
use Imoing\Pptx\Parts\Slide\BaseSlidePart;
use Imoing\Pptx\Shapes\AutoShape\Shape;
use Imoing\Pptx\Shapes\GroupShape;
use Imoing\Pptx\Shapes\ShapeTree\BasePlaceholders;
use Imoing\Pptx\Shapes\ShapeTree\LayoutShapes;
use Imoing\Pptx\Shapes\ShapeTree\SlideShapes;
use Imoing\Pptx\Slide\Slide;
use Imoing\Pptx\Slide\SlideLayout;
use Imoing\Pptx\Slide\SlideMaster;
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
    protected Slide|SlideShapes|SlideLayout|LayoutShapes|SlideMaster|self|BasePlaceholders $_parent;
    public function __construct(BaseShapeElement $shapeElement, mixed $parent)
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

    public function getHeight(): ?Length
    {
        return $this->_element->cy;
    }

    public function setHeight(Length $height): void
    {
        $this->_element->cy = $height;
    }

    public function getLeft(): ?Length
    {
        return $this->_element->x;
    }

    public function setLeft(Length $left): void
    {
        $this->_element->x = $left;
    }

    public function getTop(): ?Length
    {
        return $this->_element->y;
    }

    public function setTop(Length $top): void
    {
        $this->_element->y = $top;
    }

    public function getWidth(): ?Length
    {
        return $this->_element->cx;
    }

    public function setWidth(Length $width): void
    {
        $this->_element->cx = $width;
    }

    /**
     * @return Length[]|null [left, top]
     */
    public function getChOff(): ?array
    {
        return null;
    }

    /**
     * @return Length[]|null [cx, cy]
     */
    public function getChExt(): ?array
    {
        return null;
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

    public function getIsPlaceholder(): bool
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

    private ?FillFormat $_fill = null;
    public function getFill(): FillFormat
    {
        if (is_null($this->_fill)) {
            $this->_fill = FillFormat::fromFillParent($this->_element->spPr);
        }
        return $this->_fill;
    }

    public function getFillColor(): ?string
    {
        return $this->fillToColor($this->getFill());
    }

    public function fillToColor(FillFormat $fill): ?string
    {
        $arr = $fill->toArray();

        $fillType = $arr['type'] ?? '';

        if ($fillType === 'color') {
            return $arr['color'];
        }

        if ($fillType === 'scheme') {
            return $this->_parent->getSchemeColor($arr['scheme']);
        }

        return null;
    }

    public function getFillArr(): array
    {
        $fill = $this->getFill();
        $color = $this->fillToColor($fill);
        if (!empty($color)) {
            return [
                'fill' => $color,
            ];
        }

        $arr = $fill->toArray();
        if (!empty($arr['type']) && !empty($arr[$arr['type']])) {
            unset($arr['type']);
            $arr['fill'] = '';
            return $arr;
        }

        return $arr;
    }

    public function getTextArr(): ?array
    {
        return null;
    }

    public function getOutlineArr(): array
    {
        return [];
    }

    public function getShadowArr(): ?array
    {
        $shadow = $this->getShadow();
        $arr = $shadow->toArray();

        if (empty($arr)) {
            return null;
        }

        $arr['color'] = $this->colorToString($arr['color']);

        return $arr;
    }

    protected function colorToString(?array $color)
    {
        $colorType = $color['type'] ?? '';
        if ($colorType === 'scheme') {
            return $this->getSchemeColor($color['scheme']);
        } elseif ($colorType === 'color') {
            return $color['color'];
        }

        return '';
    }

    public function toArray(): array
    {
        $arr = [
            'id' => $this->shapeId,
            'left' => $this->left?->px,
            'top' => $this->top?->px,
            'width' => $this->width?->px,
            'height' => $this->height?->px,
            'rotate' => $this->rotation,
            'name' => $this->name,
            'isPlaceholder' => $this->isPlaceholder,
        ];
        assert(is_array($arr));

        return $arr;
    }

}