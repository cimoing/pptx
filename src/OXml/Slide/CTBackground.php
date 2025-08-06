<?php

namespace Imoing\Pptx\OXml\Slide;

use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;

/**
 * @method void _insert_bgPr(CTBackgroundProperties $properties)
 * @property ?CTBackgroundProperties $bgPr
 * @property mixed $bgRef
 */
class CTBackground extends BaseOXmlElement
{
    #[ZeroOrOne("p:bgPr", successors: [])]
    protected ?CTBackgroundProperties $_bgPr;

    #[ZeroOrOne("p:bgRef", successors: [])]
    protected mixed $_bgRef;

    public function add_noFill_bgPr()
    {
        $xml = sprintf("<p:bgPr %s>
        <a:noFill/>
        <a:effectLst/>
        </p:bgPr>", nsdecls(["a", "p"]));
        $obj = makeOXmlElement($this->ownerDocument, $xml);
        assert($obj instanceof CTBackgroundProperties);

        $this->_insert_bgPr($obj);
        return $obj;
    }

    public function toArray(): array
    {
        return [
            'type' => '',
        ];
    }
}