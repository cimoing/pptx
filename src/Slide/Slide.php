<?php

namespace Imoing\Pptx\Slide;

use Imoing\Pptx\OXml\Dml\Fill\CTLevelParaProperties;
use Imoing\Pptx\Parts\Slide\SlidePart;
use Imoing\Pptx\Shapes\Base\Theme;
use Imoing\Pptx\Shapes\ShapeTree\LayoutPlaceholders;
use Imoing\Pptx\Shapes\ShapeTree\SlidePlaceholders;
use Imoing\Pptx\Shapes\ShapeTree\SlideShapes;

/**
 * @property SlidePart $part
 * @property-read bool $followMasterBackground
 * @property-read bool $hasNotesSlide
 * @property-read SlidePlaceholders $placeholders
 * @property SlideShapes $shapes
 * @property-read Theme $theme 主题
 */
class Slide extends BaseSlide
{
    public function getFollowMasterBackground(): bool
    {
        return is_null($this->_element->bg);
    }

    public function getHasNotesSlide(): bool
    {
        //TODO
        return false;
    }

    private ?SlidePlaceholders $_placeholders = null;
    public function getPlaceholders(): SlidePlaceholders
    {
        if (is_null($this->_placeholders)) {
            $this->_placeholders = new SlidePlaceholders($this->_element->spTree, $this);
        }
        return $this->_placeholders;
    }

    private ?LayoutPlaceholders $_layoutPlaceholders = null;
    public function getLayoutPlaceholders(): LayoutPlaceholders
    {
        if (is_null($this->_layoutPlaceholders)) {
            $this->_layoutPlaceholders = $this->part->slideLayout->getPlaceholders();
        }

        return $this->_layoutPlaceholders;
    }

    private ?SlideShapes $_shapes = null;
    public function getShapes(): SlideShapes
    {
        if (is_null($this->_shapes)) {
            $this->_shapes = new SlideShapes($this->_element->spTree, $this);
        }

        return $this->_shapes;
    }

    private ?Theme $_theme = null;
    protected function getTheme(): Theme
    {
        if (is_null($this->_theme)) {
            $theme = $this->part->slideLayout->theme;

            $this->_theme = $theme;
        }

        return $this->_theme;
    }

    public function toArray(): array
    {
        $background = $this->getInheritedBackground();

        $elements = [];
        $phIdxList = [];

        $unwrap = function ($element) use (&$elements, &$unwrap, &$phIdxList) {
            $isPlaceholder = array_key_exists('isPlaceholder', $element) && $element['isPlaceholder'];
            unset($element['isPlaceholder']);
            if (!array_key_exists('elements', $element)) {
                $elements[] = $element;
                if ($isPlaceholder) {
                    $phIdxList[$element['id']] = count($elements) - 1;
                }
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

        // layout elements
        $layouts = $this->part->slideLayout->toArray();
        $layoutElements = array_filter($layouts['elements'], function ($element) {
            return !array_key_exists('isPlaceholder', $element) || $element['isPlaceholder'] === false;
        });
        foreach ($layoutElements as &$element) {
            unset($layoutElements['isPlaceholder']);
        }
        unset($element);

        $backgroundArr = $background->toArray();
        if ($backgroundArr['type'] == 'none') {
            $backgroundArr = $layouts['background'];
        } elseif ($backgroundArr['type'] == 'scheme') {
            $backgroundArr = [
                'type' => 'solid',
                'color' => $this->theme->getSchemeColor($backgroundArr['scheme']),
            ];
        }

        return [
            'background' => $backgroundArr,
            'name' => $this->name,
            'elements' => array_merge($layoutElements, $elements),
        ];
    }
}