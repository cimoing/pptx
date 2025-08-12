<?php

namespace Imoing\Pptx\Slide;

use Imoing\Pptx\OXml\Dml\Fill\CTLevelParaProperties;
use Imoing\Pptx\Parts\Slide\SlidePart;
use Imoing\Pptx\Shapes\ShapeTree\SlidePlaceholders;
use Imoing\Pptx\Shapes\ShapeTree\SlideShapes;

/**
 * @property SlidePart $part
 * @property-read bool $followMasterBackground
 * @property-read bool $hasNotesSlide
 * @property-read SlidePlaceholders $placeholders
 * @property SlideShapes $shapes
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

    public function getPhLevelPPr(int $phIdx, int $level): ?CTLevelParaProperties
    {
        return $this->part->slideLayout->getPhLevelPPr($phIdx, $level);
    }

    private ?SlideShapes $_shapes = null;
    public function getShapes(): SlideShapes
    {
        if (is_null($this->_shapes)) {
            $this->_shapes = new SlideShapes($this->_element->spTree, $this);
        }

        return $this->_shapes;
    }

    private ?array $_colorScheme = null;

    public function getColorScheme(): array
    {
        return $this->part->slideLayout->getColorScheme();
    }

    public function getColorMap(): array
    {
        return $this->part->slideLayout->getColorMap();
    }

    public function getSchemeColor(string $scheme): string
    {
        return $this->part->slideLayout->getSchemeColor($scheme);
    }

    public function toArray(): array
    {
        $background = $this->getInheritedBackground();

        $elements = [];
        $phIdxList = [];

        $unwrap = function ($element) use (&$elements, &$unwrap, &$phIdxList) {
            $isPlaceholder = array_key_exists('isPlaceholder', $element) && $element['isPlaceholder'];
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
                $child['top'] += $element['top'];
                $child['left'] += $element['left'];
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

        $backgroundArr = $background->toArray();
        if ($backgroundArr['type'] == 'none') {
            $backgroundArr = $layouts['background'];
        } elseif ($backgroundArr['type'] == 'scheme') {
            $backgroundArr = [
                'type' => 'solid',
                'color' => $this->getSchemeColor($backgroundArr['scheme']),
            ];
        }

        return [
            'background' => $backgroundArr,
            'name' => $this->name,
            'elements' => array_merge($layoutElements, $elements),
        ];
    }
}