<?php

namespace Imoing\Pptx\Shapes\Base;

use Imoing\Pptx\Dml\Color\ColorFormat;
use Imoing\Pptx\Dml\Fill\Fill;
use Imoing\Pptx\OXml\Dml\Color\CTSchemeColor;
use Imoing\Pptx\OXml\Slide\CTColorMap;
use Imoing\Pptx\OXml\Theme\CTColorScheme;
use Imoing\Pptx\OXml\Theme\CTFonts;
use Imoing\Pptx\OXml\Theme\CTOfficeStyleSheet;
use Imoing\Pptx\Parts\Theme\OfficeStyleSheetPart;
use Imoing\Pptx\Shared\PartElementProxy;

/**
 * @property-read OfficeStyleSheetPart $part
 * @property-read CTOfficeStyleSheet $_element
 */
class Theme extends PartElementProxy
{
    const SCHEME_NAMES = ['dk1', 'lt1', 'dk2', 'lt2', 'accent1', 'accent2', 'accent3', 'accent4', 'accent5', 'accent6', 'tx1', 'tx2', 'bg1', 'bg2', 'hlink', 'folHlink'];

    protected static function parseClrScheme(CTColorScheme $clrScheme): array
    {
        $colorScheme = [];
        foreach (self::SCHEME_NAMES as $k) {
            $clr = $clrScheme->{$k};
            if (!is_null($clr)) {
                $fmt = ColorFormat::fromColorChoiceParent($clr, null); // 此处不会也不应当出现对主题色的引用
                $colorScheme[$k] = (string) $fmt->getRgb();
            }
        }

        return $colorScheme;
    }

    protected static function parseFontScheme(CTFonts $fonts): array
    {
        $arr = [
            'latin' => $fonts->latin?->typeface ?: '',
            'ea' => $fonts->ea?->typeface ?: '',
            'cs' => $fonts->cs?->typeface ?: '',
        ];
        foreach ($fonts->font_lst as $font) {
            if ($font->script) {
                $arr[$font->script] = $font->typeface;
            }
        }

        return $arr;
    }

    public static function parseClrMap(?CTColorMap $overrides): array
    {
        $map = $overrides ? array_filter([
            'bg1' => $overrides->bg1,
            'tx1' => $overrides->tx1,
            'bg2' => $overrides->bg2,
            'tx2' => $overrides->tx2,
            'accent1' => $overrides->accent1,
            'accent2' => $overrides->accent2,
            'accent3' => $overrides->accent3,
            'accent4' => $overrides->accent4,
            'accent5' => $overrides->accent5,
            'accent6' => $overrides->accent6,
            'hlink' => $overrides->hlink,
            'folHlink' => $overrides->folHlink,
        ]) : [];

        return $map;
    }

    private array $_colorScheme = [];

    protected function getColorScheme(): array
    {
        if (empty($this->_colorScheme)) {
            $this->_colorScheme = self::parseClrScheme($this->_element->themeElements->clrScheme);
        }
        return $this->_colorScheme;
    }

    /**
     * 合并新的颜色配置并返回新主题对象
     * @param array $colorScheme
     * @return $this
     */
    public function withColorScheme(array $colorScheme): static
    {
        $colorScheme = array_merge($this->getColorScheme(), $colorScheme);
        $theme = clone $this;
        $theme->_colorScheme = $colorScheme;
        return $theme;
    }

    private array $_fontScheme = [
        'major' => [],
        'minor' => [],
    ];
    protected function getFontScheme(): array
    {
        return $this->_fontScheme;
    }

    /**
     * 合并字体设置并返回新的主题对象
     * @param array $fontScheme
     * @return static
     */
    public function withFontScheme(array $fontScheme): static
    {
        $fontScheme = array_merge_recursive($this->_fontScheme, $fontScheme);
        $theme = clone $this;
        $theme->_fontScheme = $fontScheme;

        return $theme;
    }

    /**
     * 获取主要字体，默认获取拉丁文
     * @param string $script
     * @return string
     */
    public function getMajorFont(string $script = "latin"): string
    {
        $fontScheme = $this->_element->themeElements->fontScheme;
        return $this->getFont($fontScheme->majorFont, $script);
    }

    /**
     * 获取次要字体，默认拉丁文
     * @param string $script
     * @return string
     */
    public function getMinorFont(string $script = "latin"): string
    {
        $fontScheme = $this->_element->themeElements->fontScheme;
        return $this->getFont($fontScheme->minorFont, $script);
    }

    protected function getFont(CTFonts $fonts, string $script): string
    {
        if (in_array($script, ['latin', 'ea', 'cs'])) {
            return $fonts->{$script}?->typeface ?: '';
        }

        foreach ($fonts->font_lst as $font) {
            if ($font->script === $script) {
                return $font->typeface;
            }
        }

        return '';
    }

    private array $_formatScheme = [];
    protected function getFormatScheme(): array
    {
        return $this->_formatScheme;
    }

    public function withFormatScheme(array $formatScheme): static
    {
        $formatScheme = array_merge($this->_formatScheme, $formatScheme);
        $theme = clone $this;
        $this->_formatScheme = $formatScheme;
        return $theme;
    }

    private array $_clrMap = [
        'dk1' => 'dk1',
        'lt1' => 'lt1',
        'dk2' => 'dk2',
        'lt2' => 'lt2',
        'accent1' => 'accent1',
        'accent2' => 'accent2',
        'accent3' => 'accent3',
        'accent4' => 'accent4',
        'accent5' => 'accent5',
        'accent6' => 'accent6',
        'tx1' => 'tx1',
        'tx2' => 'tx2',
        'bg1' => 'bg1',
        'bg2' => 'bg2',
        'hlink' => 'hlink',
        'folHlink' => 'folHlink',
    ];

    protected function getClrMap(): array
    {
        return $this->_clrMap;
    }

    public function withClrMap(?CTColorMap $colorMap): static
    {
        $arr = self::parseClrMap($colorMap);

        $clrMap = array_merge($this->_clrMap, $arr);
        $theme = clone $this;
        $theme->_clrMap = $clrMap;
        return $theme;
    }

    /**
     * 获取映射的颜色
     * @param string $name
     * @return string
     */
    public function getSchemeColor(string $name): string
    {
        $alias = $this->_clrMap[$name] ?? $name;

        $colorScheme = $this->getColorScheme();

        return $colorScheme[$alias] ?? '#000000';
    }

    /**
     * @param int $idx
     * @param CTSchemeColor[] $phClrLst
     * @return Fill|null
     */
    public function getFill(int $idx, array $phClrLst = []): ?Fill
    {
        if ($idx <= 1000) {
            $base = 1;
            $children = $this->_element->themeElements->fmtScheme->fillStyleLst->getChildren();
        } else {
            $base = 1001;
            $children = $this->_element->themeElements->fmtScheme->bgFillStyleLst->getChildren();
        }
        foreach ($children as $k => $child) {
            $id = $k + $base;
            if ($id === $idx) {
                return Fill::create($child, $this, $phClrLst);
            }
        }

        return null;
    }

    public function toArray(): array
    {
        return [
            'themeColors' => [
                $this->getSchemeColor('accent1'),
                $this->getSchemeColor('accent2'),
                $this->getSchemeColor('accent3'),
                $this->getSchemeColor('accent4'),
                $this->getSchemeColor('accent5'),
                $this->getSchemeColor('accent6'),
            ],
        ];
    }
}