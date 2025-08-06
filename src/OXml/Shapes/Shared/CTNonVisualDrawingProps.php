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
    protected ?CTHyperlink $_hlinkClick;

    #[ZeroOrOne("a:hlinkHover", successors: ["a:extLst"])]
    protected ?CTHyperlink $_hlinkHover;

    #[RequiredAttribute("id", STDrawingElementId::class)]
    protected string $_id;

    #[RequiredAttribute("name", XsdString::class)]
    protected string $_name;
}