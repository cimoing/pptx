<?php

namespace Imoing\Pptx\OXml\Shapes\Shared;

use Imoing\Pptx\OXml\Action\CTHyperlink;
use Imoing\Pptx\OXml\SimpleTypes\STDrawingElementId;
use Imoing\Pptx\OXml\SimpleTypes\XsdString;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\RequiredAttribute;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;

/**
 * @method CTHyperlink get_or_add_hlinkClick()
 * @method CTHyperlink get_or_add_hlinkHover()
 * @property ?CTHyperlink $hlinkClick
 * @property ?CTHyperlink $hlinkHover
 * @property string $id
 * @property string $name
 */
class CTNonVisualDrawingProps extends BaseOXmlElement
{
    #[ZeroOrOne("a:hlinkClick", successors: ["a:hlinkHover", "a:extLst"])]
    protected ?CTHyperlink $hlinkClick;

    #[ZeroOrOne("a:hlinkHover", successors: ["a:extLst"])]
    protected ?CTHyperlink $hlinkHover;

    #[RequiredAttribute("id", STDrawingElementId::class)]
    public string $id;

    #[RequiredAttribute("name", XsdString::class)]
    protected string $name;
}