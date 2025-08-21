<?php

namespace Imoing\Pptx\Slide;

use Imoing\Pptx\Common\Coordinate;
use Imoing\Pptx\Enum\PPPlaceholderType;
use Imoing\Pptx\OXml\Dml\Fill\CTLevelParaProperties;
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
class SlideLayout extends BaseSlide
{
    public function getInheritedBackground(): Background
    {
        if (!$this->_element->cSld->bg) {
            $bg = $this->part->slideMaster->getBackground();
        } else {
            $bg = $this->getBackground();
        }

        return $bg;
    }

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

    public function getPhLevelPPr(int $phIdx, int $level): ?CTLevelParaProperties
    {
        $ph = $this->placeholders->get($phIdx);
        if (!$ph) {
            return null;
        }

        $pPr = $ph->getLevelPPr($level);
        if ($pPr) {
            return $pPr;
        }

        return $this->slideMaster->getPhLevelPPr($ph->element->phType, $level);
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

    public function getColorMap(): array
    {
        $clrMap = $this->_element->clrMapOvr?->overrideClrMapping;
        $map = $clrMap ? array_filter([
            'bg1' => $clrMap->bg1,
            'tx1' => $clrMap->tx1,
            'bg2' => $clrMap->bg2,
            'tx2' => $clrMap->tx2,
            'accent1' => $clrMap->accent1,
            'accent2' => $clrMap->accent2,
            'accent3' => $clrMap->accent3,
            'accent4' => $clrMap->accent4,
            'accent5' => $clrMap->accent5,
            'accent6' => $clrMap->accent6,
            'hlink' => $clrMap->hlink,
            'folHlink' => $clrMap->folHlink,
        ]) : [];

        return array_merge($this->slideMaster->getColorMap(), $map);
    }

    public function getSchemeColor(string $scheme): string
    {
        $map = $this->getColorMap();
        $alias = $map[$scheme];
        return $this->slideMaster->getColorScheme()[$alias];
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

    public function getPlaceholderLevelPProperties(int $phIdx, int $level): ?CTLevelParaProperties
    {
        $ph = $this->placeholders->get($phIdx);
        if (!$ph) {
            return null;
        }

        $pPr = $ph->getLevelPProperties($level);
    }

    private ?array $_colorScheme = null;
    public function getColorScheme(): array
    {
        if (null === $this->_colorScheme) {
            $this->_colorScheme = $this->getSlideMaster()->getColorScheme();
        }

        return $this->_colorScheme;
    }

    public function toArray(): array
    {
        $fill = $this->getBackground()->toArray();
        if (!empty($fill) && $fill['type'] === 'scheme') {
            $fill = [
                'type' => 'color',
                'color' => $this->getColorScheme()[$fill['scheme']],
            ];
        }

        $elements = [];
        $unwrap = function ($element) use (&$elements, &$unwrap) {
            if (!array_key_exists('elements', $element)) {
                $elements[] = $element;
                return;
            }

            $children = $element['elements'];
            unset($element['elements']);
            foreach ($children as $child) {
                // 涉及旋转的
                $unwrap(array_merge($element, $child));
            }
        };
        foreach ($this->shapes->toArray() as $element) {
            $unwrap($element);
        }
        //$elements = $this->shapes->toArray();

        return [
            'background' => $fill,
            'name' => $this->name,
            'elements' => $elements,
        ];
    }
}