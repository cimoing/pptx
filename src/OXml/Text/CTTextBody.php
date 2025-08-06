<?php

namespace Imoing\Pptx\OXml\Text;

use Imoing\Pptx\OXml\Ns\NsMap;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\OneAndOnlyOne;
use Imoing\Pptx\OXml\XmlChemy\OneOrMore;

/**
 * @method CTTextParagraph add_p()
 * @property CTTextParagraph[] $p_lst
 */
class CTTextBody extends BaseOXmlElement
{
    #[OneAndOnlyOne("a:bodyPr")]
    protected CTTextBodyProperties $_bodyPr;

    #[OneOrMore("a:p")]
    protected CTTextParagraph $_p;

    public function clearContent(): void
    {
        foreach($this->p_lst as $p) {
            $this->removeChild($p->element);
        }
    }

    public function getDefRPr(): CTTextCharacterProperties
    {
        $p = $this->p_lst[0];
        $pPr = $p->get_or_add_pPr();
        return $pPr->get_or_add_defRPr();
    }

    public function is_empty(): bool
    {
        $ps = $this->p_lst;
        if (count($ps) > 1) {
            return false;
        }

        if (!$ps) {
            throw new \Exception("p:txBody must have at least one a:p");
        }

        if ($ps[0]->textContent != "") {
            return false;
        }

        return true;
    }

    public static function create(\DOMDocument $dom): CTTextBody
    {
        $xml = self::_txBody_tmpl();
        $obj = makeOXmlElement($dom, $xml);
        assert($obj instanceof CTTextBody);

        return $obj;
    }

    public static function new_a_txBody(): CTTextBody
    {
        $xml = self::_a_txBody_tmpl();
        $obj = parseXml($xml);
        assert($obj instanceof CTTextBody);
        return $obj;
    }

    public static function new_p_txBody(\DOMDocument $dom): CTTextBody
    {
        $xml = self::_p_txBody_tmpl();
        $obj = makeOXmlElement($dom, $xml);
        assert($obj instanceof CTTextBody);
        return $obj;
    }

    public static function new_txPr(): BaseOXmlElement
    {
        $xml = sprintf('<c:txPr %s>'.
    '<a:bodyPr/>'.
    '<a:lstStyle/>'.
    '<a:p>'.
        '<a:pPr>'.
            '<a:defRPR/>'.
        '</a:pPr>'.
    '</a:p>'.
'</c:txPr>',
        nsdecls(["a","c"]));

        return parseXml($xml);
    }

    public function unclear_content(): void
    {
        if (count($this->p_lst) > 0) {
            return;
        }

        $this->add_p();
    }

    private static function _a_txBody_tmpl(): string
    {
        return sprintf("<a:txBody %s><a:bodyPr/><a:p/></a:txBody>", nsdecls("a"));
    }

    private static function _p_txBody_tmpl(): string
    {
        return sprintf("<p:txBody %s><a:bodyPr/><a:p/></p:txBody>", nsdecls(["a","p"]));
    }

    private static function _txBody_tmpl(): string
    {
        return sprintf('<p:txBody %s><a:bodyPr/><a:lstStyle/><a:p/></p:txBody>', nsdecls(["a", "p"]));
    }
}