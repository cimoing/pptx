<?php

namespace Imoing\Pptx\Shapes\Base;

use Imoing\Pptx\Common\BaseObject;
use Imoing\Pptx\Common\Coordinate;
use Imoing\Pptx\Common\Point;
use Imoing\Pptx\Dml\Effect\ShadowFormat;
use Imoing\Pptx\Dml\Fill\FillFormat;
use Imoing\Pptx\Enum\MsoAutoShapeType;
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
use Imoing\Pptx\Util\Emu;
use Imoing\Pptx\Util\Length;

/**
 * @property-read BaseShapeElement $element
 * @property-read $clickAction
 * @property-read bool $hasChart
 * @property-read bool $hasTable
 * @property-read bool $hasTextFrame
 * @property Length[] $absOff
 * @property Length $left
 * @property Length $top
 * @property Length $width
 * @property Length $height
 * @property bool $flipV
 * @property bool $flipH
 * @property-read bool $isPlaceholder
 * @property string $name
 * @property-read BaseSlidePart $part
 * @property-read PlaceholderFormat $placeholderFormat
 * @property float $absRotation
 * @property float $rotation 当前形状旋转角度
 * @property float $parentRotation 当前形状的父级旋转角度
 * @property float $globalRotation 当前形状的全局旋转角度
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


    /**
     * @return Emu[]
     */
    public function getAbsOff(): array
    {
        $offset = Coordinate::calChildOffset($this, $this->_parent);
        return [new Emu((int) $offset[0]), new Emu((int) $offset[1])];
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

    /**
     * 获取绝对旋转角度
     * @return float
     */
    public function getAbsRotation(): float
    {
        return $this->rotation + $this->_parent->absRotation;
    }

    public function getRotation(): float
    {
        return $this->_element->rot;
    }

    public function setRotation(float $rotation): void
    {
        $this->_element->rot = $rotation;
    }

    public function getParentRotation(): float
    {
        return $this->_parent->rotation;
    }

    public function getGlobalRotation(): float
    {
        return $this->rotation + $this->parentRotation;
    }

    public function getOffsetPoint(): Point
    {
        return new Point(
            ($this->left?->emu ?: 0),
            ($this->top?->emu ?: 0),
        );
    }

    /**
     * 获取绝对偏移点
     * @return Point
     */
    public function getAbsOffsetPoint(): Point
    {
        return $this->_parent->getAbsPoint($this->getOffsetPoint());
    }

    public function getAbsPoint(Point $relativePoint): Point
    {
        $offset = $this->getOffsetPoint();
        $center = $this->getCenterPoint();

        // 反转
        if ($this->flipV) {
            //$relativePoint->y = $center->y - ($relativePoint->y - $center->y);
        }
        if ($this->flipH) {
            //$relativePoint->x = $center->x - ($relativePoint->x - $center->x);
        }

        $rot = $this->rotation;
        if ($rot != 0) {
            $relativePoint = $relativePoint->rotate($rot, $center);
        }

        // 相对上级位置
        $relativePoint = $relativePoint->move($offset);
        return $this->_parent->getAbsPoint($relativePoint);
    }

    public function getRAbsPoint(Point $point): Point
    {
        $offset = $this->getOffsetPoint();
        return $this->_parent->getAbsPoint($point->move($offset));
    }

    /**
     * 相对中心点 子节点均按照此点进行旋转并执行偏移，未偏移的中心点
     * @return Point
     */
    public function getCenterPoint(): Point
    {
        $relative = new Point(
            $this->width?->emu ?: 0,
            $this->height?->emu ?: 0,
        );

        return (new Point(0,0))->getCenter($relative);
    }

    protected function rotateLine(array $data, $angleDeg): array
    {
        $start = $data['start'];

        $end = $data['end'];


        $angleRad = $angleDeg * M_PI / 180;


        $midX = ($start[0] + $end[0]) / 2;
        $midY = ($start[1] + $end[1]) / 2;

        $startTransX = $start[0] - $midX;
        $startTransY = $start[1] - $midY;
        $endTransX = $end[0] - $midX;
        $endTransY = $end[1] - $midY;

        $cosA = cos($angleRad);
        $sinA = sin($angleRad);

        $startRotX = $startTransX * $cosA - $startTransY * $sinA;
        $startRotY = $startTransX * $sinA + $startTransY * $cosA;

        $endRotX = $endTransX * $cosA - $endTransY * $sinA;
        $endRotY = $endTransX * $sinA + $endTransY * $cosA;

        $startNewX = $startRotX + $midX;
        $startNewY = $startRotY + $midY;
        $endNewX = $endRotX + $midX;
        $endNewY = $endRotY + $midY;

        $beforeMinx = min($start[0], $end[0]);
        $beforeMiny = min($start[1], $end[1]);


        $afterMinX = min($startNewX, $endNewX);
        $afterMinY = min($startNewY, $endNewY);

        $startAdjustedX = $startNewX - $afterMinX;
        $startAdjustedY = $startNewY - $afterMinY;
        $endAdjustedX = $endNewX - $afterMinX;
        $endAdjustedY = $endNewY - $afterMinY;

        $startAdjusted = [$startAdjustedX, $startAdjustedY];
        $endAdjusted = [$endAdjustedX, $endAdjustedY];

        $data['left'] += $afterMinX - $beforeMinx;
        $data['top'] += $afterMinY - $beforeMiny;

        $data['start'] = $startAdjusted;
        $data['end'] = $endAdjusted;

        return $data;
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

    public function getAutoShapeType(): ?MsoAutoShapeType
    {
        return null;
    }

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

    public function getLineArr(): ?array
    {
        $shapeType = $this->getAutoShapeType()?->getXmlValue();
        if (empty($shapeType)) {
            return null;
        }

        $svgBox = $this->getSvgBox();

        $start = $this->getAbsOffsetPoint();
        $end = $this->getAbsPoint(new Point($this->width?->emu ?: 1, $this->height->emu));

        $outline = $this->getOutlineArr();
        $data = array_merge($svgBox, [
            'id' => $this->shapeId,
            'name' => $this->name,
            'isPlaceholder' => $this->isPlaceholder,
            'width' => $outline['width'] ?? 1,
            'type' => 'line',
            'start' => [$start->getLx()->htmlVal - $svgBox['left'], $start->getLy()->htmlVal - $svgBox['top']],
            'end' => [$end->getLx()->htmlVal - $svgBox['left'], $end->getLy()->htmlVal - $svgBox['top']],
            'color' => $outline['color'] ?? '',
            'style' => $outline['style'] ?? '',
            'points' => ['', $shapeType == MsoAutoShapeType::LINE_INVERSE->getXmlValue() ? 'arrow' : ''],
        ]);

        if (str_contains($shapeType, 'bentConnector')) {
            $data['broken2'] = [
                abs(($data['start'][0] - $data['end'][0]) / 2),
                abs(($data['start'][1] - $data['end'][1]) / 2)
            ];
        }

        if (str_contains($shapeType, 'curvedConnector')) {
            $cubic = [
                abs(($data['start'][0] - $data['end'][0]) / 2),
                abs(($data['start'][1] - $data['end'][1]) / 2)
            ];
            $data['cubic'] = [$cubic, $cubic];
        }

        return $data;
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
        $arr = array_merge([
            'id' => $this->shapeId,
            'rotate' => $this->absRotation,
            'name' => $this->name,
            'isPlaceholder' => $this->isPlaceholder,
        ], $this->getSvgBox());
        assert(is_array($arr));

        return $arr;
    }

    public function getSvgBox(): array
    {
        $offset = $this->getAbsOffsetPoint(); // 获取绝对位置
        $center = $this->getAbsPoint($this->getCenterPoint()); // 当前图形中心点
        $rotate = $this->absRotation - $this->rotation;
        $o = $offset->rotate(-$rotate, $center); // 旋转回去（offset为旋转前的点）

        return [
            'left' => $o->lx->htmlVal,
            'top' => $o->ly->htmlVal,
            'width' => $this->width?->htmlVal ?: 0,
            'height' => $this->height?->htmlVal ?: 0,
        ];
    }

}