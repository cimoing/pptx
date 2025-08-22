<?php

namespace Imoing\Pptx\Shapes\Base;

use Imoing\Pptx\Common\BaseObject;
use Imoing\Pptx\Dml\Color\ColorFormat;
use Imoing\Pptx\OXml\Slide\CTColorMap;
use Imoing\Pptx\OXml\Theme\CTColorMapOverrides;
use Imoing\Pptx\OXml\Theme\CTColorScheme;
use Imoing\Pptx\OXml\Theme\CTFonts;
use Imoing\Pptx\OXml\Theme\CTOfficeStyleSheet;

class Theme extends BaseObject
{
    const SCHEME_NAMES = ['dk1', 'lt1', 'dk2', 'lt2', 'accent1', 'accent2', 'accent3', 'accent4', 'accent5', 'accent6', 'tx1', 'tx2', 'bg1', 'bg2', 'hlink', 'folHlink'];

    public function __construct(array $colorScheme = [], array $fonScheme = [], array $formatScheme = [], array $colorMap = [])
    {
        parent::__construct();

        $this->_colorScheme = array_merge($this->_colorScheme, $colorScheme);
        $this->_fontScheme = array_merge_recursive($this->_fontScheme, $fonScheme);
        $this->_formatScheme = array_merge($this->_formatScheme, $formatScheme);
        $this->_clrMap = array_merge($this->_clrMap, $colorMap);
    }

    public static function createFromStyleSheet(CTOfficeStyleSheet $styleSheet): static
    {
        $colorScheme = self::parseClrScheme($styleSheet->themeElements->clrScheme);

        $fontScheme = [
            'major' => self::parseFontScheme($styleSheet->themeElements->fontScheme->majorFont),
            'minor' => self::parseFontScheme($styleSheet->themeElements->fontScheme->minorFont),
        ];

        return new static($colorScheme, $fontScheme);
    }

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

    private array $_colorScheme = [
        'lt1' => '#FFFFFF',
        'dk1' => '#000000',
        'accent1' => '#4472C4',
        'accent2' => '#ED7D31',
        'accent3' => '#A5A5A5',
        'accent4' => '#FFC000',
        'accent5' => '#772B01',
        'accent6' => '#ED7D31',
        'hlink' => '#0563C1',
        'folHlink' => '#954F72',
        'bg1' => '#FFFFFF',
        'bg2' => '#FFFFFF',
        'tx1' => '#000000',
        'tx2' => '#000000',
    ];
    protected function getColorScheme(): array
    {
        return $this->_colorScheme;
    }

    /**
     * 合并新的颜色配置并返回新主题对象
     * @param array $colorScheme
     * @return $this
     */
    public function withColorScheme(array $colorScheme): static
    {
        $colorScheme = array_merge($this->_colorScheme, $colorScheme);
        return new static($colorScheme, $this->_fontScheme, $this->_formatScheme, $this->_clrMap);
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
        return new static($this->_colorScheme, $fontScheme, $this->_formatScheme, $this->_clrMap);
    }

    /**
     * 获取主要字体，默认获取拉丁文
     * @param string $script
     * @return string
     */
    public function getMajorFont(string $script = "latin"): string
    {
        return array_key_exists($script, $this->_fontScheme['major']) ? $this->_fontScheme['major'][$script] : '';
    }

    /**
     * 获取次要字体，默认拉丁文
     * @param string $script
     * @return string
     */
    public function getMinorFont(string $script = "latin"): string
    {
        return array_key_exists($script, $this->_fontScheme['minor']) ? $this->_fontScheme['minor'][$script] : '';
    }

    private array $_formatScheme = [];
    protected function getFormatScheme(): array
    {
        return $this->_formatScheme;
    }

    public function withFormatScheme(array $formatScheme): static
    {
        $formatScheme = array_merge($this->_formatScheme, $formatScheme);
        return new static($this->_colorScheme,$this->_fontScheme, $formatScheme, $this->_clrMap);
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

    public function withClrMap(array $clrMap): static
    {
        $clrMap = array_merge($this->_clrMap, $clrMap);
        return new static($this->_colorScheme,$this->_fontScheme,$this->_formatScheme,$clrMap);
    }

    /**
     * 获取映射的颜色
     * @param string $name
     * @return string
     */
    public function getSchemeColor(string $name): string
    {
        $alias = $this->_clrMap[$name] ?? '';

        return $this->_colorScheme[$alias] ?? '#000000';
    }
}