<?php

namespace Imoing\Pptx\OXml\Shapes\AutoShape;

use Imoing\Pptx\Enum\MsoAutoShapeType;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\RequiredAttribute;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;

/**
 * @property ?CTGeomGuideList $avLst
 * @property MsoAutoShapeType $prst
 * @property-read CTGeomGuide[] $gdLst
 * @method CTGeomGuideList _add_avLst()
 * @method void _remove_avLst()
 */
class CTPresetGeometry2D extends BaseOXmlElement
{
    #[ZeroOrOne("a:avLst")]
    protected ?CTGeomGuideList $_avLst;

    #[RequiredAttribute("prst", MsoAutoShapeType::class)]
    protected MsoAutoShapeType $_prst;

    public function getGdLst(): array
    {
        /**
         * @var ?CTGeomGuideList $avLst
         */
        $avLst = $this->__get('avLst');
        if (empty($avLst)) {
            return [];
        }

        return $avLst->gd_lst;
    }

    public function rewriteGuides(array $guides): void
    {
        $this->_remove_avLst();
        $avLst = $this->_add_avLst();
        foreach ($guides as $guide) {
            $gd = $avLst->_add_gd();
            $gd->name = $guide['name'];
            $gd->fmla = sprintf("val %d", $guide['value']);
        }
    }
}