<?php

namespace Imoing\Pptx\OXml\Drawing;

use Imoing\Pptx\OXml\Dml\Fill\CTLevelParaProperties;
use Imoing\Pptx\OXml\XmlChemy\BaseOXmlElement;
use Imoing\Pptx\OXml\XmlChemy\ZeroOrOne;

/**
 * @property ?CTLevelParaProperties $lvl1pPr
 * @property ?CTLevelParaProperties $lvl2pPr
 * @property ?CTLevelParaProperties $lvl3pPr
 * @property ?CTLevelParaProperties $lvl4pPr
 * @property ?CTLevelParaProperties $lvl5pPr
 * @property ?CTLevelParaProperties $lvl6pPr
 * @property ?CTLevelParaProperties $lvl7pPr
 * @property ?CTLevelParaProperties $lvl8pPr
 * @property ?CTLevelParaProperties $lvl9pPr
 */
class CTListStyle extends BaseOXmlElement
{
    #[ZeroOrOne("a:lvl1pPr")]
    protected ?CTLevelParaProperties $_lvl1pPr;

    #[ZeroOrOne("a:lvl2pPr")]
    protected ?CTLevelParaProperties $_lvl2pPr;

    #[ZeroOrOne("a:lvl3pPr")]
    protected ?CTLevelParaProperties $_lvl3pPr;

    #[ZeroOrOne("a:lvl4pPr")]
    protected ?CTLevelParaProperties $_lvl4pPr;

    #[ZeroOrOne("a:lvl5pPr")]
    protected ?CTLevelParaProperties $_lvl5pPr;

    #[ZeroOrOne("a:lvl6pPr")]
    protected ?CTLevelParaProperties $_lvl6pPr;

    #[ZeroOrOne("a:lvl7pPr")]
    protected ?CTLevelParaProperties $_lvl7pPr;

    #[ZeroOrOne("a:lvl8pPr")]
    protected ?CTLevelParaProperties $_lvl8pPr;

    #[ZeroOrOne("a:lvl9pPr")]
    protected ?CTLevelParaProperties $_lvl9pPr;
}