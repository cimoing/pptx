<?php

namespace Imoing\Pptx\Slide;

use Imoing\Pptx\Enum\PPPlaceholderType;
use Imoing\Pptx\Parts\Slide\SlideLayoutPart;
use Imoing\Pptx\Shapes\Placeholder\SlidePlaceholder;
use Imoing\Pptx\Shapes\ShapeTree\LayoutPlaceholders;
use Imoing\Pptx\Shapes\ShapeTree\LayoutShapes;

/**
 * @property SlideLayoutPart $part
 * @property-read LayoutPlaceholders $placeholders
 * @property-read LayoutShapes $shapes
 * @property-read SlideMaster $slideMaster
 * @property-read array $usedBySlides
 */
class SlideLayout extends BasesLide
{
    /**
     * @return \Traversable<int,SlidePlaceholder>
     */
    public function iterClonablePlaceholders(): \Traversable
    {
        $latentPhTypes = [
            PPPlaceholderType::DATE,
            PPPlaceholderType::FOOTER,
            PPPlaceholderType::SLIDE_NUMBER,
        ];

        foreach ($this->placeholders as $placeholder) {
            if (!in_array($placeholder, $latentPhTypes)) {
                yield $placeholder;
            }
        }
    }

    private ?LayoutPlaceholders $_placeholders = null;
    public function getPlaceholders(): LayoutPlaceholders
    {
        if (null === $this->_placeholders) {
            $this->_placeholders = new LayoutPlaceholders($this->_element->spTree, $this);
        }

        return $this->_placeholders;
    }

    private ?LayoutShapes $_shapes = null;
    public function getShapes(): LayoutShapes
    {
        if (is_null($this->_shapes)) {
            $this->_shapes = new LayoutShapes($this->_element->spTree, $this);
        }
        return $this->_shapes;
    }

    public function getSlideMaster(): SlideMaster
    {
        return $this->part->slideMaster;
    }

    public function getUsedBySlides(): array
    {
        $slides = $this->part->package->presentationPart->getPresentation()->slides;
        $items = [];
        foreach ($slides as $slide) {
            if ($slide->slideLayout == $this) {
                $items[] = $slide;
            }
        }

        return $items;
    }

    public function toArray(): array
    {
        return [
            'fill' => $this->getBackground()->toArray(),
            'elements' => $this->getShapes()->toArray(),
        ];
    }
}