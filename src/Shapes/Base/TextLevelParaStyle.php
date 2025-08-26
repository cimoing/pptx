<?php

namespace Imoing\Pptx\Shapes\Base;

use Imoing\Pptx\Common\BaseObject;
use Imoing\Pptx\Dml\Fill\FillFormat;
use Imoing\Pptx\Enum\MsoFillType;
use Imoing\Pptx\Enum\MsoTextStrikeType;
use Imoing\Pptx\Enum\MsoTextUnderlineType;
use Imoing\Pptx\OXml\Dml\Fill\CTLevelParaProperties;
use Imoing\Pptx\OXml\Drawing\CTListStyle;
use Imoing\Pptx\OXml\Text\CTTextCharacterProperties;

/**
 */
class TextLevelParaStyle extends BaseObject
{
    private array $_levelStyles = [];

    private Theme $_theme;

    private ?CTLevelParaProperties $_properties;

    private ?TextLevelParaStyle $_parent = null;

    public function __construct(?CTLevelParaProperties $properties, Theme $theme)
    {
        parent::__construct([]);
        $this->_properties = $properties;
        $this->_theme = $theme;
    }

    public function withChild(CTLevelParaProperties $properties, Theme $theme): static
    {
        $o = new static($properties, $theme);
        $o->_parent = $this;
        return $o;
    }

    public static function parseTextCharacter(?CTTextCharacterProperties $properties, Theme $theme): array
    {
        if (empty($properties)) {
            return [];
        }

        $fill = FillFormat::fromFillParent($properties, $theme);
        $color = $fill->type === MsoFillType::SOLID ? $fill->foreColor : null;

        return array_filter([
            'color' => (string) $color?->getRgb() ?: null,
            'font-size' => $properties->sz?->htmlVal,
            'font-family' => $properties->latin?->typeface,
            'font-bold' => $properties->b,
            'font-style' => $properties->i ? 'italic' : null,
            'text-decoration' => $properties->u === MsoTextUnderlineType::SINGLE_LINE ? 'underline' : null,
            'text-decoration-line' => $properties->strike === MsoTextStrikeType::SINGLE ? 'line-through' : null,
        ], function ($val) {
            return !is_null($val);
        });
    }

    public static function parseLevelParaProperties(?CTLevelParaProperties $properties, Theme $theme): array
    {
        if (empty($properties)) {
            return [];
        }

        $base = self::parseTextCharacter($properties->defRPr, $theme);

        return array_merge($base, array_filter([
            'text-align' => $properties->algn?->getHtmlValue(),
            'tab-size' => $properties->defTabSz?->htmlVal,
        ], function ($val) {
            return !is_null($val);
        }));
    }

    public static function parseListStyle(?CTListStyle $listStyle, Theme $theme): array
    {
        $items = [];
        for ($i = 0; $i < 9; $i++) {
            $name = sprintf("lvl%dpPr", $i + 1);
            $items[$i] = self::parseLevelParaProperties($listStyle->{$name}, $theme);
        }

        return $items;
    }

    public function withListStyle(?CTListStyle $listStyle, Theme $theme): static
    {
        $items = self::parseListStyle($listStyle, $theme);
        return $this->withStyles($items, $theme);
    }

    public function withStyles(array $styles, Theme $theme): static
    {
        $styles = array_merge_recursive($this->_levelStyles, $styles);

        return new static($styles, $theme);
    }

    public function getStyles(): array
    {
        return self::parseLevelParaProperties($this->_properties, $this->_theme);
    }

    public function getLevel(): int
    {
        $tagName = $this->_properties->tagName;
        preg_match('/^lvl(%d)pPr$/m', $tagName, $matches);

        assert(!empty($matches));
        return (int) $matches[1];
    }

    public function getStylesByLevel(int $level = 0): array
    {
        $arr = array_key_exists($level, $this->_levelStyles) ? $this->_levelStyles[$level] : [];

        return array_filter($arr, function ($style) {
            return !is_null($style);
        });
    }

    public function getMajorFont(): string
    {
        return $this->_theme->getMajorFont();
    }

    public function getMinorFont(): string
    {
        return $this->_theme->getMinorFont();
    }

    public function isBuChar(): bool
    {
        $o = $this->_properties?->buChar;
        return !empty($o) || $this->_parent?->isBuChar();
    }

    public function isBuAutoNum(): bool
    {
        $o = $this->_properties?->buAutoNum;
        return !empty($o);
    }
}