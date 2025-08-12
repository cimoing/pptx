<?php

namespace Imoing\Pptx\Shapes\Placeholder;

use Imoing\Pptx\OXml\Shapes\AutoShape\CTShape;

/**
 * @property CTShape $element
 */
class MasterPlaceholder extends BasePlaceHolder
{
    public function getLevelPPr(int $level): ?\Imoing\Pptx\OXml\Dml\Fill\CTLevelParaProperties
    {
        $lstStyle = $this->element->txBody?->lstStyle;
        if (!$lstStyle) {
            return null;
        }
        $propName = 'lvl' . $level . 'pPr';
        return $lstStyle->$propName;
    }
}