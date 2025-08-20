<?php

namespace Imoing\Pptx\OXml\Theme;

use Imoing\Pptx\OXml\Dml\Fill\AbsFill;
use Imoing\Pptx\OXml\Dml\Fill\CTBlipFillProperties;
use Imoing\Pptx\OXml\Dml\Fill\CTGradientFillProperties;
use Imoing\Pptx\OXml\Dml\Fill\CTGroupFillProperties;
use Imoing\Pptx\OXml\Dml\Fill\CTNoFillProperties;
use Imoing\Pptx\OXml\Dml\Fill\CTPatternFillProperties;
use Imoing\Pptx\OXml\Dml\Fill\CTSolidColorFillProperties;
use Imoing\Pptx\OXml\Ns\NsMap;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrMore;

/**
 * @property CTNoFillProperties[] $noFill_lst
 * @property CTGradientFillProperties[] $gradFill_lst
 * @property CTSolidColorFillProperties[] $solidFill_lst
 * @property CTBlipFillProperties[] $blipFill_lst
 * @property CTPatternFillProperties[] $pattFill_lst
 * @property CTGroupFillProperties[] $grpFill_lst
 */
class CTFillStyleList extends BaseOXmlElement
{
    #[ZeroOrMore("a:noFill")]
    protected array $_noFill;

    #[ZeroOrMore("a:solidFill")]
    protected array $_solidFill;

    #[ZeroOrMore("a:gradFill")]
    protected array $_gradFill;

    #[ZeroOrMore("a:blipFill")]
    protected array $_blipFill;

    #[ZeroOrMore("a:pattFill")]
    protected array $_pattFill;

    #[ZeroOrMore("a:grpFill")]
    protected array $_grpFill;

    /**
     * 获取子节点
     * @return \Iterator<int,AbsFill>
     */
    public function getChildren(): \Iterator
    {
        foreach ($this->childNodes as $child) {
            if ($child instanceof \DOMElement) {
                $obj = NsMap::castDom($child);
                if ($obj instanceof AbsFill) {
                    yield $obj;
                }
            }
        }
    }
}