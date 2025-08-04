<?php

namespace Imoing\Pptx\OXml\Shapes\AutoShape;

use DOMElement;
use Imoing\Pptx\Enum\MsoAutoShapeType;
use Imoing\Pptx\Enum\PPPlaceholderType;
use Imoing\Pptx\OXml\Ns\NsMap;
use Imoing\Pptx\OXml\Shapes\Shared\BaseShapeElement;
use Imoing\Pptx\OXml\Shapes\Shared\CTLineProperties;
use Imoing\Pptx\OXml\Shapes\Shared\CTShapeProperties;
use Imoing\Pptx\OXml\Text\CTTextBody;
use Imoing\Pptx\OXml\XmlChemy\OneAndOnlyOne;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;
use Imoing\Pptx\Util\Length;

/**
 * @method CTTextBody get_or_add_txBody()
 * @property CTShapeNonVisual $nvSpPr
 * @property CTShapeProperties $spPr
 * @property ?CTTextBody $txBody
 * @property-read bool $isTextBox
 * @property-read ?CTLineProperties $ln
 * @property-read ?MsoAutoShapeType $prst
 * @property-read ?CTPresetGeometry2D $prstGeom
 * @property-read bool $isAutoShape
 */
class CTShape extends BaseShapeElement
{
    #[OneAndOnlyOne("p:nvSpPr")]
    protected CTShapeNonVisual $_nvSpPr;

    #[OneAndOnlyOne("p:spPr")]
    protected CTShapeProperties $_spPr;

    #[ZeroOrOne("p:txBody", successors: ["p:extLst"])]
    protected ?CTTextBody $txBody;

    public function add_path(Length $w, Length $h): CTPath2D
    {
        $custGeom = $this->spPr->custGeom;
        if (is_null($custGeom)) {
            throw new \Exception("shape must be freeform");
        }

        $pathLst = $custGeom->get_or_add_pathLst();
        return $pathLst->add_path($w, $h);
    }

    public function get_or_add_ln(): CTLineProperties
    {
        return $this->spPr->get_or_add_ln();
    }

    public function getHasCustomGeometry(): bool
    {
        return !is_null($this->spPr->custGeom);
    }

    public function getIsAutoShape(): bool
    {
        $prstGeom = $this->prstGeom;
        if (is_null($prstGeom)) {
            return false;
        }

        return $this->nvSpPr->cNvSpPr->txBox !== true;
    }

    public function getIsTextBox(): bool
    {
        return $this->nvSpPr->cNvSpPr->txBox === true;
    }

    public function getLn(): ?CTLineProperties
    {
        return$this->spPr->ln;
    }

    public static function createAutoShapeSp(\DOMDocument $dom, int $id, string $name, string $prst, int $left, int $top, int $width, int $height): CTShape
    {
        $xml = sprintf(
        "<p:sp %s>".
            "  <p:nvSpPr>".
            '    <p:cNvPr id="%s" name="%s"/>'.
            "    <p:cNvSpPr/>".
            "    <p:nvPr/>".
            "  </p:nvSpPr>".
            "  <p:spPr>".
            "    <a:xfrm>".
            '      <a:off x="%s" y="%s"/>'.
            '      <a:ext cx="%s" cy="%s"/>'.
            "    </a:xfrm>\n".
            '    <a:prstGeom prst="%s">'.
            "      <a:avLst/>\n".
            "    </a:prstGeom>\n".
            "  </p:spPr>\n".
            "  <p:style>\n".
            '    <a:lnRef idx="1">'.
            '      <a:schemeClr val="accent1"/>'.
            "    </a:lnRef>\n".
            '    <a:fillRef idx="3">'.
            '      <a:schemeClr val="accent1"/>'.
            "    </a:fillRef>\n".
            '    <a:effectRef idx="2">'.
            '      <a:schemeClr val="accent1"/>'.
            "    </a:effectRef>\n".
            '    <a:fontRef idx="minor">'.
            '      <a:schemeClr val="lt1"/>'.
            "    </a:fontRef>\n".
            "  </p:style>\n".
            "  <p:txBody>\n".
            '    <a:bodyPr rtlCol="0" anchor="ctr"/>'.
            "    <a:lstStyle/>\n".
            "    <a:p>\n".
            '      <a:pPr algn="ctr"/>'.
            "    </a:p>\n".
            "  </p:txBody>\n".
            "</p:sp>", $id, $name, $left, $top, $width, $height, $prst);

        $obj = makeOXmlElement($dom, $xml);
        assert($obj instanceof CTShape);
        return $obj;
    }

    public static function createFreeFormSp(\DOMDocument $dom, int $shapeId, string $name, int $x, int $y, int $cx, int $cy): CTShape
    {
        $xml = sprintf(
        "<p:sp %s>".
            "  <p:nvSpPr>".
            '    <p:cNvPr id="%s" name="%s"/>'.
            "    <p:cNvSpPr/>".
            "    <p:nvPr/>".
            "  </p:nvSpPr>".
            "  <p:spPr>".
            "    <a:xfrm>".
            '      <a:off x="%s" y="%s"/>'.
            '      <a:ext cx="%s" cy="%s"/>'.
            "    </a:xfrm>".
            "    <a:custGeom>".
            "      <a:avLst/>\n".
            "      <a:gdLst/>\n".
            "      <a:ahLst/>\n".
            "      <a:cxnLst/>\n".
            '      <a:rect l="l" t="t" r="r" b="b"/>'.
            "      <a:pathLst/>\n".
            "    </a:custGeom>\n".
            "  </p:spPr>\n".
            "  <p:style>\n".
            '    <a:lnRef idx="1">'.
            '      <a:schemeClr val="accent1"/>'.
            "    </a:lnRef>\n".
            '    <a:fillRef idx="3">'.
            '      <a:schemeClr val="accent1"/>'.
            "    </a:fillRef>\n".
            '    <a:effectRef idx="2">'.
            '      <a:schemeClr val="accent1"/>'.
            "    </a:effectRef>\n".
            '    <a:fontRef idx="minor">'.
            '      <a:schemeClr val="lt1"/>'.
            "    </a:fontRef>\n".
            "  </p:style>\n".
            "  <p:txBody>\n".
            '    <a:bodyPr rtlCol="0" anchor="ctr"/>'.
            "    <a:lstStyle/>\n".
            "    <a:p>\n".
            '      <a:pPr algn="ctr"/>'.
            "    </a:p>\n".
            "  </p:txBody>\n".
            "</p:sp>"
        , nsdecls(["a", "p"]),$shapeId, $name, $x, $y, $cx, $cy);
        $obj = makeOXmlElement($dom, $xml);
        assert($obj instanceof CTShape);
        return $obj;
    }

    public static function createPlaceholderSp(\DOMDocument $dom, int $id, string $name, PPPlaceholderType $phType, string $orient, $sz, $idx): CTShape
    {
        $xml = sprintf("<p:sp %s><p:nvSpPr><p:cNvPr id=\"%d\" name=\"%s\"/><p:cNvSpPr><a:spLocks noGrp=\"1\"/>".
            "</p:cNvSpPr><p:nvPr/></p:nvSpPr><p:spPr/></p:sp>",
            nsdecls(['a', 'p']), $id, $name);
        $fragment = $dom->createDocumentFragment();
        $fragment->appendXML($xml);
        $node = $fragment->firstChild;

        assert($node instanceof DOMElement);

        $sp = NsMap::castDom($node);
        assert($sp instanceof CTShape);

        $ph = $sp->nvSpPr->nvPr->get_or_add_ph();
        $ph->type = $phType;
        $ph->orient = $orient;
        $ph->idx = $idx;
        $ph->sz = $sz;

        $types = [
            PPPlaceholderType::TITLE,
            PPPlaceholderType::CENTER_TITLE,
            PPPlaceholderType::SUBTITLE,
            PPPlaceholderType::BODY,
            PPPlaceholderType::OBJECT,
        ];

        if (in_array($phType, $types)) {
            $sp->append(CTTextBody::create($sp->ownerDocument)->element);
        }

        return $sp;
    }

    public static function createTextBoxSp(\DOMDocument $dom, int $id, string $name, int $left, int $top, int $width, int $height): CTShape
    {
        $xml = sprintf(
        "<p:sp %s><p:nvSpPr><p:cNvPr id=\"%d\" name=\"%s\"/><p:cNvSpPr txBox=\"1\"/><p:nvPr/></p:nvSpPr><p:spPr>".
        "<a:xfrm><a:off x=\"%d\" y=\"%d\"/><a:ext cx=\"%d\" cy=\"%d\"/></a:xfrm>".
        "<a:prstGeom prst=\"rect\"><a:avLst/></a:prstGeom><a:noFill/></p:spPr>".
        "<p:txBody><a:bodyPr wrap=\"none\"><a:spAutoFit/></a:bodyPr><a:lstStyle/><a:p/></p:txBody></p:sp>"
        ,nsdecls(["a", "p"]), $id, $name, $left, $top, $width, $height);

        $sp = makeOXmlElement($dom, $xml);
        assert($sp instanceof CTShape);

        return $sp;
    }

    public function getPrst(): ?MsoAutoShapeType
    {
        $prstGeom = $this->getPrstGeom();
        if (is_null($prstGeom)) {
            return null;
        }

        return $prstGeom->prst;
    }

    public function getPrstGeom(): ?CTPresetGeometry2D
    {
        return $this->spPr->prstGeom;
    }

    protected function _new_txBody(): CTTextBody
    {
        return CTTextBody::new_p_txBody($this->ownerDocument);
    }

    protected static function getTextboxSpTmpl() {
    }
}