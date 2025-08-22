<?php

namespace Imoing\Pptx\Shapes\ShapeTree;

use Imoing\Pptx\Common\Coordinate;
use Imoing\Pptx\Common\Point;
use Imoing\Pptx\Common\TraitArrayAccess;
use Imoing\Pptx\Enum\PPPlaceholderType;
use Imoing\Pptx\OXml\Shapes\GroupShape\CTGroupShape;
use Imoing\Pptx\OXml\Shapes\Shared\BaseShapeElement;
use Imoing\Pptx\OXml\SimpleTypes\STDirection;
use Imoing\Pptx\Shapes\Base\BaseShape;
use Imoing\Pptx\Shapes\Base\Theme;
use Imoing\Pptx\Shapes\Base\Transform2D;
use Imoing\Pptx\Shapes\Placeholder\LayoutPlaceholder;
use Imoing\Pptx\Shared\ParentedElementProxy;
use Imoing\Pptx\Types\ProvidesPart;
use Imoing\Pptx\Util\Emu;
use Imoing\Pptx\Util\Length;

/**
 * @property bool $turboAddEnabled
 * @property float $absRotation 绝对旋转角度
 * @property float $rotation 当前旋转角度
 * @property Length[] $absOff
 * @property Length $top 相对偏移
 * @property Length $left 相对偏移
 * @property Length $width
 * @property Length $height
 * @property Length[] $childOff 子节点相对偏移
 * @property Length[] $childSize
 */
class BaseShapes extends ParentedElementProxy implements \IteratorAggregate, \Countable, \ArrayAccess
{
    use TraitArrayAccess;
    protected CTGroupShape $_spTree;

    protected ?int $_cachedMaxShapeId = null;

    public function __construct(CTGroupShape $spTree, ProvidesPart $part)
    {
        parent::__construct($spTree, $part);
        $this->_spTree = $spTree;
        $this->_cachedMaxShapeId = null;
    }

    public function offsetGet($offset): BaseShape
    {
        $elements = iterator_to_array($this->iterMemberElms());
        $element = $elements[$offset];

        return $this->shapeFactory($element);
    }

    /**
     * @return \Traversable<int,BaseShape>
     */
    public function getIterator(): \Traversable
    {
        foreach ($this->iterMemberElms() as $elm) {
            yield $this->shapeFactory($elm);
        }
    }

    public function count(): int
    {
        return count(iterator_to_array($this->iterMemberElms()));
    }

    protected function get__arrayItems(): array
    {
        return iterator_to_array($this->iterMemberElms());
    }

    public function clonePlaceholder(LayoutPlaceholder $placeholder): void
    {
        $shape = $placeholder->element;
        list($phType, $orient, $sz, $idx) = [$shape->phType, $shape->phOrient, $shape->phSz, $shape->phIdx];

        $id = $this->getNextShapeId();
        $name = $this->getNextPhName($phType, $id, $orient);
        $this->_spTree->add_placeholder($id, $name, $phType, $orient, $sz, $idx);
    }

    public function getPhBasename(PPPlaceholderType $phType): string
    {
        return match ($phType) {
            PPPlaceholderType::BITMAP => "ClipArt Placeholder",
            PPPlaceholderType::BODY => "Text Placeholder",
            PPPlaceholderType::CENTER_TITLE, PPPlaceholderType::TITLE => "Title",
            PPPlaceholderType::CHART => "Chart Placeholder",
            PPPlaceholderType::DATE => "Date Placeholder",
            PPPlaceholderType::FOOTER => "Footer Placeholder",
            PPPlaceholderType::HEADER => "Header Placeholder",
            PPPlaceholderType::MEDIA_CLIP => "Media Placeholder",
            PPPlaceholderType::OBJECT => "Content Placeholder",
            PPPlaceholderType::ORG_CHART => "SmartArt Placeholder",
            PPPlaceholderType::PICTURE => "Picture Placeholder",
            PPPlaceholderType::SLIDE_NUMBER => "Slide Number Placeholder",
            PPPlaceholderType::SUBTITLE => "Subtitle",
            PPPlaceholderType::TABLE => "Table Placeholder",
            default => sprintf("%s Placeholder", $phType->name),
        };
    }

    public function getTurboAddEnabled(): bool
    {
        return !is_null($this->_cachedMaxShapeId);
    }

    public function setTurboAddEnabled(bool $value): void
    {
        $this->_cachedMaxShapeId = $value ? $this->_spTree->getMaxShapeId() : null;
    }

    public function getTransform2D(): ?Transform2D
    {
        $xfrm = $this->_spTree->getXfrm();
        if (!$xfrm) {
            return null;
        }

        return new Transform2D($xfrm);
    }

    public function getWidth(): Length
    {
        return $this->_spTree->grpSpPr?->xfrm?->ext?->cx ?: new Emu(0);
    }

    public function getHeight(): Length
    {
        return $this->_spTree->grpSpPr?->xfrm?->ext?->cy ?: new Emu(0);
    }

    public static function isMemberElm(BaseShapeElement $shapeElement): bool
    {
        return true;
    }

    protected function iterMemberElms(): \Traversable
    {
        foreach ($this->_spTree->iter_shape_elms() as $elm) {
            if (static::isMemberElm($elm)) {
                yield $elm;
            }
        }
    }

    protected function getNextPhName(PPPlaceholderType $phType, int $id, string $orient): string
    {
        $baseName = $this->getPhBasename($phType);
        if ($orient == STDirection::VERT) {
            $baseName = "Vertical {$baseName}";
        }

        $numPart = $id - 1;
        $nodes = $this->_spTree->xpath("//p:cNvPr/@name");
        $names = [];
        foreach ($nodes as $node) {
            if ($node instanceof \DOMAttr) {
                $names[] = $node->value;
            }
        }

        while (true) {
            $name = sprintf("%s %d", $baseName, $numPart);
            if (!in_array($name, $names)) {
                break;
            }
            $numPart++;
        };

        return $name;
    }

    protected function getNextShapeId(): int
    {
        if (!is_null($this->_cachedMaxShapeId)) {
            $this->_cachedMaxShapeId++;
            return $this->_cachedMaxShapeId;
        }
        return $this->_spTree->getMaxShapeId() + 1;
    }

    protected function getTheme(): Theme
    {
        return $this->parent->theme;
    }

    protected function shapeFactory(BaseShapeElement $shapeElement): BaseShape
    {
        return ShapeTree::baseShapeFactory($shapeElement,$this);
    }

    public function toArray(): array
    {
        $arr = [];
        foreach ($this as $shape) {
            $arr[] = $shape->toArray();
        }
        return $arr;
    }
}