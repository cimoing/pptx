<?php

namespace Imoing\Pptx\Slide;

use Imoing\Pptx\Common\Coordinate;
use Imoing\Pptx\Enum\PPPlaceholderType;
use Imoing\Pptx\OXml\Dml\Fill\CTLevelParaProperties;
use Imoing\Pptx\Parts\Slide\SlideLayoutPart;
use Imoing\Pptx\Shapes\Base\Theme;
use Imoing\Pptx\Shapes\Placeholder\SlidePlaceholder;
use Imoing\Pptx\Shapes\ShapeTree\LayoutPlaceholders;
use Imoing\Pptx\Shapes\ShapeTree\LayoutShapes;

/**
 * @property SlideLayoutPart $part
 * @property-read LayoutPlaceholders $placeholders
 * @property-read LayoutShapes $shapes
 * @property-read SlideMaster $slideMaster
 * @property-read array $usedBySlides
 * @property-read Theme $theme
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

    private ?Theme $_theme = null;
    protected function getTheme(): Theme
    {
        if (is_null($this->_theme)) {
            $theme = $this->slideMaster->theme;
            $this->_theme = $theme->withClrMap(Theme::parseClrMap($this->_element->clrMapOvr?->overrideClrMapping));
        }

        return $this->_theme;
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
        $fill = $this->getBackground()->toArray();
        if (!empty($fill) && $fill['type'] === 'scheme') {
            $fill = [
                'type' => 'color',
                'color' => $this->theme->getSchemeColor($fill['scheme']),
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
                $unwrap(array_merge($element, $child));
            }
        };
        foreach ($this->shapes->toArray() as $element) {
            $unwrap($element);
        }

        return [
            'background' => $fill,
            'name' => $this->name,
            'elements' => $elements,
        ];
    }
}