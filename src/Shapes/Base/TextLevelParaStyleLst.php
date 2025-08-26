<?php

namespace Imoing\Pptx\Shapes\Base;

use Imoing\Pptx\Common\BaseObject;
use Imoing\Pptx\OXml\Drawing\CTListStyle;

class TextLevelParaStyleLst extends BaseObject
{
    private ?CTListStyle $_style;
    private Theme $_theme;

    private ?TextLevelParaStyleLst $_parent = null;

    public function __construct(?CTListStyle $style, Theme $theme)
    {
        parent::__construct();
        $this->_style = $style;
        $this->_theme = $theme;
    }

    /**
     * 带有层级关系的样式
     * @param int $level
     * @return ?TextLevelParaStyle
     */
    public function getLevelParaStyle(int $level): ?TextLevelParaStyle
    {
        $attrLevel = $level + 1;
        $attrName = "lvl{$attrLevel}pPr";
        $el = $this->_style->$attrName;
        if (!empty($this->_parent)) {
            $p = $this->_parent->getLevelParaStyle($level);
            if ($p) {
                return $el ? $p->withChild($el, $this->_theme) : $p;
            }
        }

        return $el ? new TextLevelParaStyle($el, $this->_theme) : new TextLevelParaStyle(null, $this->_theme);
    }

    /**
     * 获取新的层级
     * @param CTListStyle $style
     * @param Theme $theme
     * @return $this
     */
    public function withChild(CTListStyle $style, Theme $theme): static
    {
        $lst = new TextLevelParaStyleLst($style, $theme);
        $lst->_parent = $this;

        return $lst;
    }
}