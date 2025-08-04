<?php

namespace Imoing\Pptx\OXml\Shapes\GroupShape;

use Imoing\Pptx\Enum\MsoConnectorType;
use Imoing\Pptx\Enum\PPPlaceholderType;
use Imoing\Pptx\OXml\Ns\NsMap;
use Imoing\Pptx\OXml\Shapes\AutoShape\CTShape;
use Imoing\Pptx\OXml\Shapes\Connector\CTConnector;
use Imoing\Pptx\OXml\Shapes\Pictures\CTPicture;
use Imoing\Pptx\OXml\Shapes\Shared\BaseShapeElement;
use Imoing\Pptx\OXml\Shapes\Shared\CTPoint2D;
use Imoing\Pptx\OXml\Shapes\Shared\CTPositiveSize2D;
use Imoing\Pptx\OXml\Shapes\Shared\CTTransform2D;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\OneAndOnlyOne;
use Imoing\Pptx\Util\Emu;

/**
 * @property CTGroupShapeNonVisual $nvGrpSpPr
 * @property CTGroupShapeProperties $grpSpPr
 * @property CTPoint2D $chOff
 * @property CTPositiveSize2D $chExt
 */
class CTGroupShape extends BaseShapeElement
{
    #[OneAndOnlyOne("p:nvGrpSpPr")]
    protected CTGroupShapeNonVisual $_nvGrpSpPr;

    #[OneAndOnlyOne("p:grpSpPr")]
    protected CTGroupShapeProperties $_grpSpPr;

    const SHAPE_TAGS = [
        'p:sp',
        'p:grpSp',
        'p:graphicFrame',
        'p:cxnSp',
        'p:pic',
        'p:contentPart',
    ];

    public static function createGrpSp(\DOMDocument $dom, int $id, string $name): CTGroupShape
    {
        $xml = sprintf(
        "<p:grpSp %s>".
              "<p:nvGrpSpPr>".
                "<p:cNvPr id=\"%d\" name=\"%s\"/>".
                "<p:cNvGrpSpPr/>".
                "<p:nvPr/>".
              "</p:nvGrpSpPr>".
              "<p:grpSpPr>".
                "<a:xfrm>".
                  "<a:off x=\"0\" y=\"0\"/>".
                  "<a:ext cx=\"0\" cy=\"0\"/>".
                  "<a:chOff x=\"0\" y=\"0\"/>".
                  "<a:chExt cx=\"0\" cy=\"0\"/>".
                "</a:xfrm>".
              "</p:grpSpPr>".
            "</p:grpSp>"
        ,nsdecls(["a", "p", "r"]),$id, $name);

        $grpSp = makeOXmlElement($dom, $xml);
        assert($grpSp instanceof CTGroupShape);
        return $grpSp;
    }

    public function add_autoshape(int $id, string $name, string $prst, int $x, int $y, int $cx, int $cy): CTShape
    {
        $sp = CTShape::createAutoShapeSp($this->ownerDocument, $id, $name, $prst, $x, $y, $cx, $cy);
        $this->insertElementBefore($sp, ["p:extLst"]);

        return $sp;
    }

    public function add_cxnSp(int $id, string $name, MsoConnectorType $typeMember, int $x, int $y, int $cx, int $cy, bool $flipH, bool $flipV): CTConnector
    {
        $prst = $typeMember->getXmlValue();
        $cxnSp = CTConnector::createCxnSp($this->ownerDocument, $id, $name, $prst, $x, $y, $cx, $cy, $flipH, $flipV);
        $this->insertElementBefore($cxnSp, ["p:extLst"]);

        return $cxnSp;
    }

    public function add_freeform_sp(int $x, int $y, int $cx, int $cy): CTShape
    {
        $shapeId = $this->getNextShapeId();
        $name = sprintf("Freeform %d", $shapeId - 1);
        $sp = CTShape::createFreeFormSp($this->ownerDocument, $shapeId, $name, $x, $y, $cx, $cy);
        $this->insertElementBefore($sp, ["p:extLst"]);

        return $sp;
    }

    public function add_grpSp(): CTGroupShape
    {
        $shapeId = $this->getNextShapeId();
        $name = sprintf("GroupSp %d", $shapeId);
        $grpSp = CTGroupShape::createGrpSp($this->ownerDocument, $shapeId, $name);
        $this->insertElementBefore($grpSp, ["p:extLst"]);

        return $grpSp;
    }

    public function add_pic(int $id, string $name, string $desc, string $rId, int $x, int $y, int $cx, int $cy): CTPicture
    {
        $pic = CTPicture::createPic($this->ownerDocument, $id, $name, $desc, $rId, $x, $y, $cx, $cy);
        $this->insertElementBefore($pic, ["p:extLst"]);
        return $pic;
    }

    public function add_placeholder(int $id, string $name, PPPlaceholderType $phType, string $orient, string $sz, int $idx): CTShape
    {
        $sp = CTShape::createPlaceholderSp($this->ownerDocument,$id, $name, $phType, $orient, $sz, $idx);
        $this->insertElementBefore($sp, ["p:extLst"]);
        return $sp;
    }

    //TODO add_table

    public function add_textbox(int $id, string $name, int $x, int $y, int $cx, int $cy): CTShape
    {
        $sp = CTShape::createTextboxSp($this->ownerDocument, $id, $name, $x, $y, $cx, $cy);
        $this->insertElementBefore($sp, ["p:extLst"]);
        return $sp;
    }

    public function getChExt(): CTPositiveSize2D
    {
        return $this->grpSpPr->get_or_add_xfrm()->get_or_add_chExt();
    }

    public function getChOff(): CTPoint2D
    {
        return $this->grpSpPr->get_or_add_xfrm()->get_or_add_chOff();
    }

    public function get_or_add_xfrm(): CTTransform2D
    {
        return $this->grpSpPr->get_or_add_xfrm();
    }

    /**
     * @return \Traversable<int, BaseShapeElement>
     */
    public function iter_ph_elms(): \Traversable
    {
        foreach($this->iter_shape_elms() as $elm) {
            if ($elm->getHasPhElm()) {
                yield $elm;
            }
        }
    }

    /**
     * @return \Iterator<int, BaseShapeElement>
     */
    public function iter_shape_elms(): \Iterator
    {
        foreach ($this->childNodes as $i => $child) {
            // 类型处理
            if ($child instanceof \DOMElement && in_array($child->tagName, self::SHAPE_TAGS)) {
                yield NsMap::castDom($child);
            }
        }
    }

    public function getMaxShapeId(): int
    {
        $nodes = $this->xpath("//@id");
        $maxId = 0;
        foreach ($nodes as $node) {
            if ($node instanceof \DOMAttr) {
                if (is_numeric($node->value) && $maxId < intval($node->value)) {
                    $maxId = intval($node->value);
                }
            }
        }

        return $maxId;
    }

    protected function recalculateExtends(): void
    {
        if ($this->tagName != "p:grpSp") {
            return;
        }

        list($x, $y, $cx, $cy) = $this->getChildExtends();
        $this->chOff->x = $this->x = $x;
        $this->chOff->y = $y;

        $this->chExt->cx = $this->cx = $cx;
        $this->chExt->cy = $this->cy = $cy;
        $this->parentElement->recalculateExtends();
    }

    public function getXfrm(): ?CTTransform2D
    {
        return $this->grpSpPr->xfrm;
    }

    protected function getChildExtends(): array
    {
        $shapes = (array) $this->iter_shape_elms();
        if (empty($shapes)) {
            return [new Emu(0), new Emu(0), new Emu(0), new Emu(0)];;
        }

        $minX = min(array_map(function (BaseShapeElement $elm) {
            return $elm->getX()->getEmu();
        }, $shapes));
        $minY = min(array_map(function (BaseShapeElement $elm) {
            return $elm->getY()->getEmu();
        }, $shapes));
        $maxX = max(array_map(function (BaseShapeElement $elm) {
            return $elm->getCx()->getEmu();
        }, $shapes));
        $maxY = max(array_map(function (BaseShapeElement $elm) {
            return $elm->getCy()->getEmu();
        }, $shapes));

        return [new Emu($minX), new Emu($minY), new Emu($maxX - $minX), new Emu($maxY - $minY)];
    }

    private function getNextShapeId(): int
    {
        $children = $this->xpath("//@id");
        $usedIds = [];
        foreach ($children as $child) {
            if ($child instanceof \DOMAttr) {
                $usedIds[] = $child->value;
            }
        }
        for ($i = 1; $i < count($usedIds)+2; $i++) {
            if (!in_array($i, $usedIds)) {
                return $i;
            }
        }

        return -1;
    }
}