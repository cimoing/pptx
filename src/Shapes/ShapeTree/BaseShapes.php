<?php

namespace Imoing\Pptx\Shapes\ShapeTree;

use Imoing\Pptx\Common\TraitArrayAccess;
use Imoing\Pptx\Enum\PPPlaceholderType;
use Imoing\Pptx\OXml\Shapes\GroupShape\CTGroupShape;
use Imoing\Pptx\OXml\Shapes\Shared\BaseShapeElement;
use Imoing\Pptx\OXml\SimpleTypes\STDirection;
use Imoing\Pptx\Shapes\Base\BaseShape;
use Imoing\Pptx\Shapes\Placeholder\LayoutPlaceholder;
use Imoing\Pptx\Shared\ParentedElementProxy;
use Imoing\Pptx\Types\ProvidesPart;

/**
 * @property bool $turboAddEnabled
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